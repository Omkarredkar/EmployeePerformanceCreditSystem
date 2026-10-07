package com.employeeperformance.system.service;

import com.employeeperformance.system.entity.Employee;
import com.employeeperformance.system.entity.MonthlyPerformance;
import com.employeeperformance.system.repository.EmployeeRepository;
import com.employeeperformance.system.repository.MonthlyPerformanceRepository;
import org.springframework.stereotype.Service;

import java.time.LocalDate;
import java.util.ArrayList;
import java.util.Comparator;
import java.util.List;

@Service
public class MonthlyPerformanceService {

    private final EmployeeRepository employeeRepository;
    private final MonthlyPerformanceRepository monthlyPerformanceRepository;
    private final PerformanceService performanceService;

    public MonthlyPerformanceService(
            EmployeeRepository employeeRepository,
            MonthlyPerformanceRepository monthlyPerformanceRepository,
            PerformanceService performanceService) {

        this.employeeRepository = employeeRepository;
        this.monthlyPerformanceRepository = monthlyPerformanceRepository;
        this.performanceService = performanceService;
    }

    public List<MonthlyPerformance> generateMonthlyEvaluation() {

        List<Employee> employees =
                employeeRepository.findByActiveTrue();

        List<MonthlyPerformance> evaluations =
                new ArrayList<>();

        if (employees.isEmpty()) {
            return evaluations;
        }

        // Recalculate current performance
        for (Employee employee : employees) {

            performanceService.calculatePerformance(
                    employee.getId()
            );
        }

        // Reload employees with updated performance
        employees =
                employeeRepository.findByActiveTrue();

        // Ranking:
        // 1. Performance descending
        // 2. Credits descending
        // 3. Employee ID ascending
        employees.sort(
                Comparator
                        .comparing(
                                Employee::getCurrentPerformance,
                                Comparator.reverseOrder()
                        )
                        .thenComparing(
                                Employee::getTotalCredits,
                                Comparator.reverseOrder()
                        )
                        .thenComparing(
                                Employee::getId
                        )
        );

        String currentMonth =
        LocalDate.now().withDayOfMonth(1).toString();

        // Remove previous evaluation for this month
        List<MonthlyPerformance> existing =
                monthlyPerformanceRepository
                        .findByMonthOrderByRankPositionAsc(
                                currentMonth
                        );

        if (!existing.isEmpty()) {
            monthlyPerformanceRepository.deleteAll(existing);
        }

        // Create monthly evaluations
        for (int i = 0; i < employees.size(); i++) {

            Employee employee =
                    employees.get(i);

            MonthlyPerformance evaluation =
                    new MonthlyPerformance();

            evaluation.setEmployee(employee);

            evaluation.setMonth(currentMonth);

            evaluation.setPerformanceScore(
                    employee.getCurrentPerformance()
            );

            evaluation.setRankPosition(i + 1);

            // Recommendation rules
            if (i == 0) {

                evaluation.setRecommendation(
                        "INCREMENT_RECOMMENDED"
                );

            } else if (i == employees.size() - 1) {

                if (employees.size() == 1) {

                    evaluation.setRecommendation(
                            "CONTINUE"
                    );

                } else {

                    evaluation.setRecommendation(
                            "REMOVAL_RECOMMENDED"
                    );
                }

            } else {

                evaluation.setRecommendation(
                        "CONTINUE"
                );
            }

            evaluation.setApproved(false);

            evaluations.add(
                    monthlyPerformanceRepository.save(
                            evaluation
                    )
            );
        }

        return evaluations;
    }

    public List<MonthlyPerformance> getCurrentMonthEvaluation() {

        String currentMonth =
        LocalDate.now().withDayOfMonth(1).toString();

        return monthlyPerformanceRepository
                .findByMonthOrderByRankPositionAsc(
                        currentMonth
                );
    }

    public MonthlyPerformance approveEvaluation(Long id) {

        MonthlyPerformance evaluation =
                monthlyPerformanceRepository
                        .findById(id)
                        .orElseThrow(
                                () -> new RuntimeException(
                                        "Monthly evaluation not found."
                                )
                        );

        evaluation.setApproved(true);

        return monthlyPerformanceRepository.save(
                evaluation
        );
    }

    public MonthlyPerformance rejectEvaluation(Long id) {

        MonthlyPerformance evaluation =
                monthlyPerformanceRepository
                        .findById(id)
                        .orElseThrow(
                                () -> new RuntimeException(
                                        "Monthly evaluation not found."
                                )
                        );

        evaluation.setApproved(false);

        return monthlyPerformanceRepository.save(
                evaluation
        );
    }
}