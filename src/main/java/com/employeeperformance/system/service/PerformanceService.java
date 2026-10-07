package com.employeeperformance.system.service;

import com.employeeperformance.system.entity.Employee;
import com.employeeperformance.system.entity.Task;
import com.employeeperformance.system.repository.EmployeeRepository;
import com.employeeperformance.system.repository.TaskRepository;
import org.springframework.stereotype.Service;

import java.time.LocalDate;
import java.time.temporal.ChronoUnit;
import java.util.List;

@Service
public class PerformanceService {

    private final EmployeeRepository employeeRepository;
    private final TaskRepository taskRepository;

    public PerformanceService(EmployeeRepository employeeRepository,
                              TaskRepository taskRepository) {
        this.employeeRepository = employeeRepository;
        this.taskRepository = taskRepository;
    }

    public double calculatePerformance(Long employeeId) {

        Employee employee = employeeRepository.findById(employeeId)
                .orElseThrow(() ->
                        new RuntimeException("Employee not found"));

        List<Task> tasks = taskRepository.findByEmployeeId(employeeId);

        if (tasks.isEmpty()) {
            employee.setCurrentPerformance(0.0);
            employeeRepository.save(employee);
            return 0.0;
        }

        double deadlineScore = calculateDeadlineScore(tasks);
        double qualityScore = calculateQualityScore(tasks);
        double completionScore = calculateCompletionScore(tasks);

        double finalScore =
                (deadlineScore * 0.40)
                + (qualityScore * 0.40)
                + (completionScore * 0.20);

        finalScore = Math.max(0, Math.min(100, finalScore));

        employee.setCurrentPerformance(finalScore);
        employeeRepository.save(employee);

        return finalScore;
    }

    private double calculateDeadlineScore(List<Task> tasks) {

        double totalScore = 0;

        for (Task task : tasks) {

            if (!task.isCompleted()) {

                if (LocalDate.now().isAfter(task.getDeadline())) {
                    totalScore += 20;
                } else {
                    totalScore += 100;
                }

                continue;
            }

            long lateDays = 0;

            if (task.getCompletionDate() != null &&
                    task.getCompletionDate().isAfter(task.getDeadline())) {

                lateDays = ChronoUnit.DAYS.between(
                        task.getDeadline(),
                        task.getCompletionDate());
            }

            if (lateDays == 0) {
                totalScore += 100;
            } else if (lateDays <= 2) {
                totalScore += 70;
            } else if (lateDays <= 5) {
                totalScore += 40;
            } else {
                totalScore += 20;
            }
        }

        return totalScore / tasks.size();
    }

    private double calculateQualityScore(List<Task> tasks) {

        double totalQuality = 0;

        for (Task task : tasks) {
            totalQuality += task.getQualityScore();
        }

        return totalQuality / tasks.size();
    }

    private double calculateCompletionScore(List<Task> tasks) {

        long completedTasks = tasks.stream()
                .filter(Task::isCompleted)
                .count();

        return ((double) completedTasks / tasks.size()) * 100;
    }
}