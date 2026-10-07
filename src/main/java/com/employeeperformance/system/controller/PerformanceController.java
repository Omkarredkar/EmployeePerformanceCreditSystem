package com.employeeperformance.system.controller;

import com.employeeperformance.system.service.PerformanceService;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/performance")
@CrossOrigin(origins = "*")
public class PerformanceController {

    private final PerformanceService performanceService;

    public PerformanceController(PerformanceService performanceService) {
        this.performanceService = performanceService;
    }

    @GetMapping("/{employeeId}")
    public ResponseEntity<Double> calculatePerformance(
            @PathVariable Long employeeId) {

        return ResponseEntity.ok(
                performanceService.calculatePerformance(employeeId)
        );
    }
}