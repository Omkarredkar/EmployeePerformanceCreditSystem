package com.employeeperformance.system.service;

import com.employeeperformance.system.entity.CreditHistory;
import com.employeeperformance.system.entity.Employee;
import com.employeeperformance.system.repository.CreditHistoryRepository;
import com.employeeperformance.system.repository.EmployeeRepository;
import org.springframework.stereotype.Service;

@Service
public class CreditService {

    private final EmployeeRepository employeeRepository;
    private final CreditHistoryRepository creditHistoryRepository;

    public CreditService(EmployeeRepository employeeRepository,
                         CreditHistoryRepository creditHistoryRepository) {
        this.employeeRepository = employeeRepository;
        this.creditHistoryRepository = creditHistoryRepository;
    }

    public int calculateCredits(double performanceScore) {

        if (performanceScore >= 90) {
            return 20;
        } else if (performanceScore >= 75) {
            return 15;
        } else if (performanceScore >= 60) {
            return 10;
        } else {
            return 5;
        }
    }

    public CreditHistory awardCredits(Long employeeId,
                                      double performanceScore) {

        Employee employee = employeeRepository.findById(employeeId)
                .orElseThrow(() ->
                        new RuntimeException("Employee not found"));

        int credits = calculateCredits(performanceScore);

        employee.setTotalCredits(
                employee.getTotalCredits() + credits
        );

        employeeRepository.save(employee);

        CreditHistory history = new CreditHistory();

        history.setEmployee(employee);
        history.setCreditsAwarded(credits);
        history.setPerformanceScore(performanceScore);
        history.setReason(
                "Credits awarded based on performance score"
        );

        return creditHistoryRepository.save(history);
    }
}