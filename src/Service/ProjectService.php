<?php

namespace App\Service;

use App\Repository\ContractRepository;
use App\Repository\InvoiceLineRepository;
use App\Repository\ProjectRepository;
use App\Repository\SubcontractRepository;
use App\Repository\TrackerProjectRepository;

class ProjectService
{
    private $contractRepository;
    private $invoiceLineRepository;
    private $projectRepository;
    private $subcontractRepository;
    private $trackerProjectRepository;

    private $overtimeFactor;
    private $holidayFactor;
    private $architectEquivalent;
    private $modelerEquivalent;

    public function __construct(ContractRepository $contractRepository, InvoiceLineRepository $invoiceLineRepository, ProjectRepository $projectRepository, SubcontractRepository $subcontractRepository, TrackerProjectRepository $trackerProjectRepository, $overtimeFactor, $holidayFactor, $architectEquivalent, $modelerEquivalent)
    {
        $this->contractRepository = $contractRepository;
        $this->invoiceLineRepository = $invoiceLineRepository;
        $this->projectRepository = $projectRepository;
        $this->subcontractRepository = $subcontractRepository;
        $this->trackerProjectRepository = $trackerProjectRepository;

        $this->overtimeFactor = $overtimeFactor;
        $this->holidayFactor = $holidayFactor;
        $this->architectEquivalent = $architectEquivalent;
        $this->modelerEquivalent = $modelerEquivalent;
    }

    public function contractSummary($project)
    {
        $data = NULL;
        $contracts = $project->getContracts();
        foreach ($contracts as $key => $contract) {
            $contractId = $contract->getId();
            $data[$contractId]['description'] = $contract->getDescription();
            $data[$contractId]['currency'] = $contract->getCurrency()->getSymbol();
            $data[$contractId]['amount'] = $contract->getAmount();
            $invoiced = $this->invoiceLineRepository->findTotalByContract($contractId);
            $data[$contractId]['invoiced'] = 0;
            if (!is_null($invoiced['invoiceTotal'])) {
                $data[$contractId]['invoiced'] = $invoiced['invoiceTotal'];
            }
            $data[$contractId]['balance'] = $data[$contractId]['amount'] - $data[$contractId]['invoiced'];
            $data[$contractId]['netTotal'] = $data[$contractId]['amount'];
            $data[$contractId]['netInvoiced'] = $data[$contractId]['invoiced'];
            $data[$contractId]['netBalance'] = $data[$contractId]['balance'];
            $subcontracts = $this->subcontractRepository->findTotalByContract($contractId);
            // Iterate over subcontract array, if there is some result
            foreach ($subcontracts as $subKey => $subcontract) {
                $data[$contractId]['subcontracts'][$subKey] = array('id' => $subcontract['id'], 'company' =>$subcontract['companyName'], 'description' => $subcontract['description'], 'currency' => $subcontract['symbol'], 'amount' => $subcontract['amount'], 'charged' => $subcontract['chargeTotal'], 'subBalance' => ($subcontract['amount'] - $subcontract['chargeTotal']));
                $data[$contractId]['netTotal'] -= $subcontract['amount'];
                $data[$contractId]['netInvoiced'] -= $subcontract['chargeTotal'];
                $data[$contractId]['netBalance'] -= ($subcontract['amount'] - $subcontract['chargeTotal']);
            }
        }

        return $data;
    }

    public function simpleProjectStats($project, $stage)
    {
        $today = time();
        $startDelivery = $project->getDeliveryStart()->getTimestamp();
        $endDelivery = $project->getDeliveryEnd()->getTimestamp();
        $weeksTillDelivery = floor(($endDelivery - $today) / 60 / 60 / 24 / 7);
        // Increasing remaining weeks by 1 because track records come in with one week of delay
        $weeks = $weeksTillDelivery + 1;
        $totalDeliverySeconds = $endDelivery - $startDelivery;
        $currentProgressSeconds = $today - $startDelivery;
        $currentProgressPercentage = floor($currentProgressSeconds / $totalDeliverySeconds * 100);

        // Get budgets for all contracts related to this project and where development stage matches
        $contracts = $this->contractRepository->findBy(['department' => $stage, 'project' => $project]);
        $data['budget'] = $this->sumBudgetedHours($contracts);
        // Save contracts in return array
        $data['contracts'] = $contracts;
        
        // Get all authorized records that are related to a specific project
        // TODO: use submitted instead of authorized trackers.
        // TODO: here, all trackers from one specific project are handed to the function, without taking into consideration if they belong to the same stage or not. The filter if the stage applies or not, is done in the function. Ideally, only trackers that were already filtered by stage should be handed to the function.
        $authorizedTrackers = $this->trackerProjectRepository->findAuthorizedByProject($project);
        $data['spent'] = $this->sumSpentHours($authorizedTrackers, $stage);

        // Calculate percentages of consumed hours per role
        foreach ($data['budget'] as $role => $budgetedHours) {
            if (!$budgetedHours) {
                $budgetedHours = 1;
            }
            $spentPercentage[$role] = $data['spent'][$role] / $budgetedHours * 100;
        }
        $data['spentPercentage'] = $spentPercentage;

        // Calculate average of remaining hours per weeks for each roles
        $remaining_architect = $this->calculateRemainingTime($data['budget']['architect'], $data['spent']['architect'], $weeks);
        $remaining_modeler = $this->calculateRemainingTime($data['budget']['modeler'], $data['spent']['modeler'], $weeks);
        $remaining_intern = $this->calculateRemainingTime($data['budget']['intern'], $data['spent']['intern'], $weeks);

        $data['remaining'] = array(
            'stage' => $stage->getDescription(),
            'weeks' => $weeksTillDelivery,
            'progress' => $currentProgressPercentage,
            'architect' => $remaining_architect,
            'modeler' => $remaining_modeler,
            'intern' => $remaining_intern,
            'spent' => $data['spent']['equivalent'],
        );

        return $data;
    }

    public function projectStatsSummary()
    {
        $projects = $this->projectRepository->findBy(['status' => 1]);
        //$projects['production'] = $this->projectRepository->findBy(['status' => 1, 'deliveryStage' => 3]);
        foreach ($projects as $key => $project) {
            $data[$key]['project'] = $project;

            $today = time();
            // TODO: perhaps move to function; same calculation is done in simpleProjectStats
            if($project->getDeliveryStart() AND $project->getDeliveryEnd()) {
                $startDelivery = $project->getDeliveryStart()->getTimestamp();
                $endDelivery = $project->getDeliveryEnd()->getTimestamp();
                $totalDeliverySeconds = $endDelivery - $startDelivery;
                $currentProgressSeconds = $today - $startDelivery;
                $currentProgressPercentage = floor($currentProgressSeconds / $totalDeliverySeconds * 100);
            }
            else {
                $currentProgressPercentage = 0;
            }

            $stage = $project->getDeliveryStage();
            // Get budgets for all contracts related to this project and where development stage matches
            $contracts = $this->contractRepository->findBy(['department' => $stage, 'project' => $project]);
            $data[$key]['budget'] = $this->sumBudgetedHours($contracts);
            
            // Get all authorized records that are related to a specific project
            // TODO: use submitted instead of authorized trackers.
            // TODO: here, all trackers from one specific project are handed to the function, without taking into consideration if they belong to the same stage or not. The filter if the stage applies or not, is done in the function. Ideally, only trackers that were already filtered by stage should be handed to the function.
            $authorizedTrackers = $this->trackerProjectRepository->findAuthorizedByProject($project);
            $data[$key]['spent'] = $this->sumSpentHours($authorizedTrackers, $stage);

            // Calculate percentages of consumed hours per role
            foreach ($data[$key]['budget'] as $role => $budgetedHours) {
                if (!$budgetedHours) {
                    $budgetedHours = 1;
                }
                $spentPercentage[$role] = $data[$key]['spent'][$role] / $budgetedHours * 100;
            }
            $data[$key]['spentPercentage'] = $spentPercentage;

            $data[$key]['remaining'] = array(
                'stage' => $stage->getDescription(),
                'progress' => $currentProgressPercentage,
            );
        }

        return $data;
    }

    private function sumBudgetedHours($contracts)
    {
        // Set basic data
        // from App\Entity\UserAnalysis: 1=unassigned, 2=architect, 3=modeler, 4=intern
        $team = array('unassigned' => 0, 'architect' => 0, 'modeler' => 0, 'intern' => 0, 'equivalent' => 0);
        // Set empty array
        $budget = $team;
        // Calculate total budget of hours, separated by role
        foreach ($contracts as $key => $contract) {
            $hoursArchitect = $contract->getHoursArchitect();
            $hoursModelling = $contract->getHoursModelling();
            $hoursIntern = $contract->getHoursIntern();

            $budget['architect'] += $hoursArchitect;
            $budget['modeler'] += $hoursModelling;
            $budget['intern'] += $hoursIntern;
            $budget['equivalent'] += $hoursIntern + $hoursModelling * $this->modelerEquivalent + $hoursArchitect * $this->architectEquivalent;
        }

        return $budget;
    }

    private function sumSpentHours($trackers, $stage)
    {
        // Set basic data
        // from App\Entity\UserAnalysis: 1=unassigned, 2=architect, 3=modeler, 4=intern
        $team = array('unassigned' => 0, 'architect' => 0, 'modeler' => 0, 'intern' => 0, 'equivalent' => 0);
        // Set empty array
        $spent = $team;
        // Get hours of each tracker and calculate totals separately per role
        foreach ($trackers as $key => $tracker) {
            $role = $tracker->getTracker()->getUserAnalysis()->getDescription();
            if ($tracker->getDepartment() == $stage) {
                $regularHours = $tracker->getRegular();
                $overtimeHours = $tracker->getOvertime();
                $holidayHours = $tracker->getHoliday();
                $totalHours = $regularHours + ($overtimeHours * $this->overtimeFactor) + ($holidayHours * $this->holidayFactor);
                $spent[$role] += $totalHours;
                switch ($role) {
                    case 'architect':
                        $equivalentHours = $totalHours * $this->architectEquivalent;
                        break;
                    case 'modeler':
                        $equivalentHours = $totalHours * $this->modelerEquivalent;
                        break;
                    case 'intern':
                        $equivalentHours = $totalHours;
                        break;
                }
                $spent['equivalent'] += $equivalentHours;
            }
        }

        return $spent;
    }

    private function calculateRemainingTime($budget, $spent, $weeks) 
    {
        $remaining = round(($budget - $spent) / $weeks, 1);
        if (($budget - $spent) <= 0) {
            $remaining = $budget - $spent;
        }

        return $remaining;
    }
}
