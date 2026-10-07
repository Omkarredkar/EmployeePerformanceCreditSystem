package com.employeeperformance.system;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

@SpringBootApplication(scanBasePackages = "com.employeeperformance.system")
public class EmployeePerformanceCreditSystemApplication {

    public static void main(String[] args) {
        SpringApplication.run(EmployeePerformanceCreditSystemApplication.class, args);
    }
}