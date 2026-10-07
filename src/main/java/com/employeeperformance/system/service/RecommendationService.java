package com.employeeperformance.system.service;

import com.employeeperformance.system.entity.Employee;
import com.employeeperformance.system.repository.EmployeeRepository;
import org.springframework.stereotype.Service;

import java.util.Comparator;
import java.util.List;

@Service
public class RecommendationService {

    private final EmployeeRepository employeeRepository;

    public RecommendationService(EmployeeRepository employeeRepository) {
        this.employeeRepository = employeeRepository;
    }

    public Employee recommendEmployeeForSkill(String requiredSkill) {

        List<Employee> matchingEmployees =
                employeeRepository
                        .findBySkillsContainingIgnoreCase(requiredSkill);

        if (matchingEmployees.isEmpty()) {
            return null;
        }

        return matchingEmployees.stream()
                .max(
                        Comparator
                                .comparingDouble(
                                        Employee::getCurrentPerformance
                                )
                                .thenComparingInt(
                                        Employee::getTotalCredits
                                )
                )
                .orElse(null);
    }
}