package com.employeeperformance.system.controller;

import com.employeeperformance.system.entity.Task;
import com.employeeperformance.system.service.TaskService;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.time.LocalDate;
import java.util.List;

@RestController
@RequestMapping("/api/tasks")
@CrossOrigin(origins = "*")
public class TaskController {

    private final TaskService taskService;

    public TaskController(TaskService taskService) {
        this.taskService = taskService;
    }

    @PostMapping
    public ResponseEntity<Task> createTask(
            @RequestParam Long employeeId,
            @RequestParam String title,
            @RequestParam(required = false) String description,
            @RequestParam String deadline) {

        Task task = taskService.createTask(
                employeeId,
                title,
                description,
                LocalDate.parse(deadline)
        );

        return ResponseEntity.ok(task);
    }

    @GetMapping("/employee/{employeeId}")
    public ResponseEntity<List<Task>> getEmployeeTasks(
            @PathVariable Long employeeId) {

        return ResponseEntity.ok(
                taskService.getEmployeeTasks(employeeId)
        );
    }

    @GetMapping("/{id}")
    public ResponseEntity<Task> getTask(
            @PathVariable Long id) {

        return ResponseEntity.ok(
                taskService.getTaskById(id)
        );
    }

    @PutMapping("/{id}/complete")
    public ResponseEntity<Task> completeTask(
            @PathVariable Long id) {

        return ResponseEntity.ok(
                taskService.completeTask(id)
        );
    }

    @PutMapping("/{id}/evaluate")
    public ResponseEntity<Task> evaluateTask(
            @PathVariable Long id,
            @RequestParam double qualityScore) {

        return ResponseEntity.ok(
                taskService.evaluateTask(id, qualityScore)
        );
    }
}