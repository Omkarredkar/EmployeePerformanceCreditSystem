package com.employeeperformance.system.service;

import com.employeeperformance.system.entity.Employee;
import com.employeeperformance.system.entity.Task;
import com.employeeperformance.system.repository.EmployeeRepository;
import com.employeeperformance.system.repository.TaskRepository;
import org.springframework.stereotype.Service;

import java.time.LocalDate;
import java.util.List;

@Service
public class TaskService {

    private final TaskRepository taskRepository;
    private final EmployeeRepository employeeRepository;

    public TaskService(TaskRepository taskRepository,
                       EmployeeRepository employeeRepository) {
        this.taskRepository = taskRepository;
        this.employeeRepository = employeeRepository;
    }

    public Task createTask(Long employeeId,
                           String title,
                           String description,
                           LocalDate deadline) {

        Employee employee = employeeRepository.findById(employeeId)
                .orElseThrow(() ->
                        new RuntimeException("Employee not found"));

        Task task = new Task();

        task.setTitle(title);
        task.setDescription(description);
        task.setAssignedDate(LocalDate.now());
        task.setDeadline(deadline);
        task.setEmployee(employee);

        return taskRepository.save(task);
    }

    public List<Task> getEmployeeTasks(Long employeeId) {
        return taskRepository.findByEmployeeId(employeeId);
    }

    public Task getTaskById(Long id) {
        return taskRepository.findById(id)
                .orElseThrow(() ->
                        new RuntimeException("Task not found with ID: " + id));
    }

    public Task completeTask(Long taskId) {

        Task task = getTaskById(taskId);

        task.setCompleted(true);
        task.setCompletionDate(LocalDate.now());

        return taskRepository.save(task);
    }

    public Task evaluateTask(Long taskId, double qualityScore) {

        if (qualityScore < 0 || qualityScore > 100) {
            throw new IllegalArgumentException(
                    "Quality score must be between 0 and 100");
        }

        Task task = getTaskById(taskId);

        task.setQualityScore(qualityScore);

        return taskRepository.save(task);
    }
}