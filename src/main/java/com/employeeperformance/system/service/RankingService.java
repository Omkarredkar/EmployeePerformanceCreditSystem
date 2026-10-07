package com.employeeperformance.system.service;

import com.employeeperformance.system.entity.Employee;
import com.employeeperformance.system.repository.EmployeeRepository;
import org.springframework.stereotype.Service;

import java.util.Comparator;
import java.util.List;

@Service
public class RankingService {

    private final EmployeeRepository employeeRepository;

    public RankingService(EmployeeRepository employeeRepository) {
        this.employeeRepository = employeeRepository;
    }

    public List<Employee> getRankedEmployees() {

        List<Employee> employees =
                employeeRepository.findByActiveTrue();

        employees.sort(
                Comparator
                        .comparingDouble(Employee::getCurrentPerformance)
                        .reversed()
                        .thenComparing(
                                Comparator.comparingInt(
                                        Employee::getTotalCredits
                                ).reversed()
                        )
                        .thenComparing(Employee::getId)
        );

        return employees;
    }
}