package com.employeeperformance.system.controller;

import com.employeeperformance.system.entity.Employee;
import com.employeeperformance.system.service.RecommendationService;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/recommendation")
@CrossOrigin(origins = "*")
public class RecommendationController {

    private final RecommendationService recommendationService;

    public RecommendationController(
            RecommendationService recommendationService) {
        this.recommendationService = recommendationService;
    }

    @GetMapping
    public ResponseEntity<Employee> recommend(
            @RequestParam String skill) {

        Employee employee =
                recommendationService
                        .recommendEmployeeForSkill(skill);

        if (employee == null) {
            return ResponseEntity.notFound().build();
        }

        return ResponseEntity.ok(employee);
    }
}