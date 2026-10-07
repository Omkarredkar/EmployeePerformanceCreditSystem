package com.employeeperformance.system.service;

import com.employeeperformance.system.entity.Employee;
import com.employeeperformance.system.repository.EmployeeRepository;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class EmployeeService {

    private final EmployeeRepository employeeRepository;
    private final PasswordEncoder passwordEncoder;

    public EmployeeService(
            EmployeeRepository employeeRepository,
            PasswordEncoder passwordEncoder) {

        this.employeeRepository = employeeRepository;
        this.passwordEncoder = passwordEncoder;
    }

    // Get all employees
    public List<Employee> getAllEmployees() {
        return employeeRepository.findAll();
    }

    // Get only active employees
    public List<Employee> getActiveEmployees() {
        return employeeRepository.findByActiveTrue();
    }

    // Get employee by ID
    public Employee getEmployeeById(Long id) {

        return employeeRepository.findById(id)
                .orElseThrow(() ->
                        new RuntimeException(
                                "Employee not found with ID: " + id
                        )
                );
    }

    // Create new employee
    public Employee createEmployee(Employee employee) {

        // Check username
        if (employee.getUsername() == null ||
                employee.getUsername().isBlank()) {

            throw new RuntimeException("Username is required.");
        }

        if (employeeRepository
                .findByUsername(employee.getUsername())
                .isPresent()) {

            throw new RuntimeException("Username already exists.");
        }

        // Check email
        if (employee.getEmail() != null &&
                !employee.getEmail().isBlank() &&
                employeeRepository.existsByEmail(employee.getEmail())) {

            throw new RuntimeException("Email already exists.");
        }

        // Check password
        if (employee.getPassword() == null ||
                employee.getPassword().isBlank()) {

            throw new RuntimeException("Password is required.");
        }

        // Encode password before saving
        employee.setPassword(
                passwordEncoder.encode(employee.getPassword())
        );

        // Default employee values
        employee.setRole("EMPLOYEE");
        employee.setActive(true);
        employee.setCurrentPerformance(0.0);
        employee.setTotalCredits(0);

        return employeeRepository.save(employee);
    }

    // Update employee
    public Employee updateEmployee(
            Long id,
            Employee updatedEmployee) {

        Employee employee = getEmployeeById(id);

        if (updatedEmployee.getFullName() != null) {
            employee.setFullName(
                    updatedEmployee.getFullName()
            );
        }

        if (updatedEmployee.getEmail() != null &&
                !updatedEmployee.getEmail().isBlank() &&
                !updatedEmployee.getEmail()
                        .equalsIgnoreCase(employee.getEmail())) {

            if (employeeRepository
                    .existsByEmail(updatedEmployee.getEmail())) {

                throw new RuntimeException("Email already exists.");
            }

            employee.setEmail(updatedEmployee.getEmail());
        }

        if (updatedEmployee.getDepartment() != null) {
            employee.setDepartment(
                    updatedEmployee.getDepartment()
            );
        }

        if (updatedEmployee.getDesignation() != null) {
            employee.setDesignation(
                    updatedEmployee.getDesignation()
            );
        }

        if (updatedEmployee.getSkills() != null) {
            employee.setSkills(
                    updatedEmployee.getSkills()
            );
        }

        // Only change password if a new password was supplied
        if (updatedEmployee.getPassword() != null &&
                !updatedEmployee.getPassword().isBlank()) {

            employee.setPassword(
                    passwordEncoder.encode(
                            updatedEmployee.getPassword()
                    )
            );
        }

        return employeeRepository.save(employee);
    }

    // Deactivate employee
    public Employee deactivateEmployee(Long id) {

        Employee employee = getEmployeeById(id);

        employee.setActive(false);

        return employeeRepository.save(employee);
    }

    // Activate employee
    public Employee activateEmployee(Long id) {

        Employee employee = getEmployeeById(id);

        employee.setActive(true);

        return employeeRepository.save(employee);
    }
}