package com.employeeperformance.system.controller;

import com.employeeperformance.system.entity.Employee;
import com.employeeperformance.system.service.RankingService;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/ranking")
@CrossOrigin(origins = "*")
public class RankingController {

    private final RankingService rankingService;

    public RankingController(RankingService rankingService) {
        this.rankingService = rankingService;
    }

    @GetMapping
    public ResponseEntity<List<Employee>> getRanking() {
        return ResponseEntity.ok(
                rankingService.getRankedEmployees()
        );
    }
}