<?php

class Process {
    public $process_id;
    public $arrival_time;
    public $burst_time;
    public $priority;

    public function __construct($process_id, $arrival_time, $burst_time, $priority) {
        $this->process_id = $process_id;
        $this->arrival_time = $arrival_time;
        $this->burst_time = $burst_time;
        $this->priority = $priority;
    }
}

function calculateFCFS(array $processes) {
    $n = count($processes);
    $waiting_times = [];
    $turnaround_times = [];
    $completion_times = [];

    $waiting_times[0] = 0;
    $completion_times[0] = $processes[0]->burst_time;
    $turnaround_times[0] = $completion_times[0] - $processes[0]->arrival_time;

    for ($i = 1; $i < $n; $i++) {
        $waiting_times[$i] = $completion_times[$i - 1] - $processes[$i]->arrival_time;
        $completion_times[$i] = $completion_times[$i - 1] + $processes[$i]->burst_time;
        $turnaround_times[$i] = $completion_times[$i] - $processes[$i]->arrival_time;
    }

    $average_waiting_time = array_sum($waiting_times) / $n;
    $average_turnaround_time = array_sum($turnaround_times) / $n;

    return [$average_waiting_time, $average_turnaround_time, $completion_times];
}

function calculateSJF(array $processes) {
    $n = count($processes);
    $waiting_times = [];
    $turnaround_times = [];
    $completion_times = [];

    usort($processes, function ($a, $b) {
        return $a->burst_time - $b->burst_time;
    });

    $waiting_times[0] = 0;
    $completion_times[0] = $processes[0]->burst_time;
    $turnaround_times[0] = $completion_times[0] - $processes[0]->arrival_time;

    for ($i = 1; $i < $n; $i++) {
        $waiting_times[$i] = $completion_times[$i - 1] - $processes[$i]->arrival_time;
        $completion_times[$i] = $completion_times[$i - 1] + $processes[$i]->burst_time;
        $turnaround_times[$i] = $completion_times[$i] - $processes[$i]->arrival_time;
    }

    $average_waiting_time = array_sum($waiting_times) / $n;
    $average_turnaround_time = array_sum($turnaround_times) / $n;

    return [$average_waiting_time, $average_turnaround_time, $completion_times];
}

function calculatePriority(array $processes) {
    $n = count($processes);
    $waiting_times = [];
    $turnaround_times = [];
    $completion_times = [];

    usort($processes, function ($a, $b) {
        return $a->priority - $b->priority;
    });

    $waiting_times[0] = 0;
    $completion_times[0] = $processes[0]->burst_time;
    $turnaround_times[0] = $completion_times[0] - $processes[0]->arrival_time;

    for ($i = 1; $i < $n; $i++) {
        $waiting_times[$i] = $completion_times[$i - 1] - $processes[$i]->arrival_time;
        $completion_times[$i] = $completion_times[$i - 1] + $processes[$i]->burst_time;
        $turnaround_times[$i] = $completion_times[$i] - $processes[$i]->arrival_time;
    }

    $average_waiting_time = array_sum($waiting_times) / $n;
    $average_turnaround_time = array_sum($turnaround_times) / $n;

    return [$average_waiting_time, $average_turnaround_time, $completion_times];
}

$processes = [
    new Process('P0', 0, 8, 3),
    new Process('P1', 1, 3, 4),
    new Process('P2', 2, 6, 1),
    new Process('P3', 3, 5, 2)
];

echo "FCFS:\n";
[$avg_waiting_fcfs, $avg_turnaround_fcfs, $completion_times_fcfs] = calculateFCFS($processes);
echo "Average Waiting Time: " . $avg_waiting_fcfs . "\n";
echo "Average Turnaround Time: " . $avg_turnaround_fcfs . "\n";
echo "Completion Times: ";
foreach ($completion_times_fcfs as $completion_time) {
    echo $completion_time . " ";
}

echo "\n\nSJF:\n";
[$avg_waiting_sjf, $avg_turnaround_sjf, $completion_times_sjf] = calculateSJF($processes);
echo "Average Waiting Time: " . $avg_waiting_sjf . "\n";
echo "Average Turnaround Time: " . $avg_turnaround_sjf . "\n";
echo "Completion Times: ";
foreach ($completion_times_sjf as $completion_time) {
    echo $completion_time . " ";
}

echo "\n\nPriority:\n";
[$avg_waiting_priority, $avg_turnaround_priority, $completion_times_priority] = calculatePriority($processes);
echo "Average Waiting Time: " . $avg_waiting_priority . "\n";
echo "Average Turnaround Time: " . $avg_turnaround_priority . "\n";
echo "Completion Times: ";
foreach ($completion_times_priority as $completion_time) {
    echo $completion_time . " ";
}
