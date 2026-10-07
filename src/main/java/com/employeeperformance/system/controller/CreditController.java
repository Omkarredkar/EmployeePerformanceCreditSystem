package com.employeeperformance.system.controller;

import com.employeeperformance.system.entity.CreditHistory;
import com.employeeperformance.system.service.CreditService;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/credits")
@CrossOrigin(origins = "*")
public class CreditController {

    private final CreditService creditService;

    public CreditController(CreditService creditService) {
        this.creditService = creditService;
    }

    @PostMapping("/{employeeId}")
    public ResponseEntity<CreditHistory> awardCredits(
            @PathVariable Long employeeId,
            @RequestParam double performanceScore) {

        return ResponseEntity.ok(
                creditService.awardCredits(
                        employeeId,
                        performanceScore
                )
        );
    }
}