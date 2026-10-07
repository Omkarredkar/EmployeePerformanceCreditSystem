package com.employeeperformance.system.controller;

import com.employeeperformance.system.entity.MonthlyPerformance;
import com.employeeperformance.system.service.MonthlyPerformanceService;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/monthly-performance")
@CrossOrigin(origins = "*")
public class MonthlyPerformanceController {

    private final MonthlyPerformanceService service;

    public MonthlyPerformanceController(
            MonthlyPerformanceService service) {

        this.service = service;
    }

    @PostMapping("/generate")
    public List<MonthlyPerformance> generateEvaluation() {

        return service.generateMonthlyEvaluation();
    }

    @GetMapping
    public List<MonthlyPerformance> getCurrentEvaluation() {

        return service.getCurrentMonthEvaluation();
    }

    @PutMapping("/{id}/approve")
    public MonthlyPerformance approve(
            @PathVariable Long id) {

        return service.approveEvaluation(id);
    }

    @PutMapping("/{id}/reject")
    public MonthlyPerformance reject(
            @PathVariable Long id) {

        return service.rejectEvaluation(id);
    }
}