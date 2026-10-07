package com.employeeperformance.system.config;

import com.employeeperformance.system.service.PerformanceService;
import com.employeeperformance.system.service.CreditService;

import com.employeeperformance.system.entity.Employee;
import com.employeeperformance.system.entity.Manager;
import com.employeeperformance.system.entity.Task;
import com.employeeperformance.system.repository.EmployeeRepository;
import com.employeeperformance.system.repository.ManagerRepository;
import com.employeeperformance.system.repository.TaskRepository;

import org.springframework.boot.CommandLineRunner;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.security.crypto.password.PasswordEncoder;

import java.time.LocalDate;
import java.time.LocalDateTime;

@Configuration
public class DataInitializer {

    @Bean
    CommandLineRunner initializeData(
        EmployeeRepository employeeRepository,
        ManagerRepository managerRepository,
        TaskRepository taskRepository,
        PasswordEncoder passwordEncoder,
        PerformanceService performanceService,
        CreditService creditService) {

        return args -> {

            /*
             * Prevent duplicate sample data.
             * If the manager already exists, initialization is skipped.
             */
            if (managerRepository.findByUsername("manager").isPresent()) {
                System.out.println("Sample data already exists. Skipping initialization.");
                return;
            }

            System.out.println("==============================================");
            System.out.println("Creating sample data...");
            System.out.println("==============================================");

            // =====================================================
            // MANAGER
            // =====================================================

            Manager manager = new Manager();

            manager.setUsername("manager");
            manager.setPassword(passwordEncoder.encode("manager123"));
            manager.setFullName("Rajesh Sharma");
            manager.setEmail("manager@employeeperformance.com");
            manager.setDepartment("Operations");
            manager.setActive(true);

            managerRepository.save(manager);

            // =====================================================
            // EMPLOYEE 1 - HIGH PERFORMER
            // =====================================================

            Employee employee1 = new Employee();

            employee1.setUsername("employee1");
            employee1.setPassword(passwordEncoder.encode("employee123"));
            employee1.setFullName("Aarav Mehta");
            employee1.setEmail("aarav@employeeperformance.com");
            employee1.setDepartment("Software Development");
            employee1.setDesignation("Senior Java Developer");
            employee1.setSkills("Java, Spring Boot, MySQL, REST API");
            employee1.setActive(true);
            employee1.setCurrentPerformance(0.0);
            employee1.setTotalCredits(0);

            employeeRepository.save(employee1);

            // =====================================================
            // EMPLOYEE 2 - GOOD PERFORMER
            // =====================================================

            Employee employee2 = new Employee();

            employee2.setUsername("employee2");
            employee2.setPassword(passwordEncoder.encode("employee123"));
            employee2.setFullName("Priya Deshmukh");
            employee2.setEmail("priya@employeeperformance.com");
            employee2.setDepartment("Software Development");
            employee2.setDesignation("Frontend Developer");
            employee2.setSkills("PHP, JavaScript, HTML, CSS");
            employee2.setActive(true);
            employee2.setCurrentPerformance(0.0);
            employee2.setTotalCredits(0);

            employeeRepository.save(employee2);

            // =====================================================
            // EMPLOYEE 3 - LOW PERFORMER
            // =====================================================

            Employee employee3 = new Employee();

            employee3.setUsername("employee3");
            employee3.setPassword(passwordEncoder.encode("employee123"));
            employee3.setFullName("Rohan Patil");
            employee3.setEmail("rohan@employeeperformance.com");
            employee3.setDepartment("Testing");
            employee3.setDesignation("QA Engineer");
            employee3.setSkills("Selenium, Java, SQL, Testing");
            employee3.setActive(true);
            employee3.setCurrentPerformance(0.0);
            employee3.setTotalCredits(0);

            employeeRepository.save(employee3);

            // =====================================================
            // EMPLOYEE 4 - AVERAGE / MIXED PERFORMER
            // =====================================================

            Employee employee4 = new Employee();

            employee4.setUsername("employee4");
            employee4.setPassword(passwordEncoder.encode("employee123"));
            employee4.setFullName("Sneha Kulkarni");
            employee4.setEmail("sneha@employeeperformance.com");
            employee4.setDepartment("Database Administration");
            employee4.setDesignation("Database Engineer");
            employee4.setSkills("MySQL, SQL, Database Design, Java");
            employee4.setActive(true);
            employee4.setCurrentPerformance(0.0);
            employee4.setTotalCredits(0);

            employeeRepository.save(employee4);

            // =====================================================
            // EMPLOYEE 1 TASKS
            // =====================================================

            createCompletedTask(
                    taskRepository,
                    employee1,
                    "Develop Employee Login API",
                    "Implement secure login API using Spring Boot and JWT authentication.",
                    LocalDate.of(2026, 9, 20),
                    LocalDate.of(2026, 9, 19),
                    95
            );

            createCompletedTask(
                    taskRepository,
                    employee1,
                    "Design Employee Database",
                    "Create and optimize database structure for employee management.",
                    LocalDate.of(2026, 9, 25),
                    LocalDate.of(2026, 9, 24),
                    92
            );

            createCompletedTask(
                    taskRepository,
                    employee1,
                    "Create Performance Service",
                    "Implement employee performance calculation logic.",
                    LocalDate.of(2026, 9, 30),
                    LocalDate.of(2026, 9, 30),
                    96
            );

            // =====================================================
            // EMPLOYEE 2 TASKS
            // =====================================================

            createCompletedTask(
                    taskRepository,
                    employee2,
                    "Create Employee Dashboard",
                    "Build responsive employee dashboard using PHP, HTML and CSS.",
                    LocalDate.of(2026, 9, 18),
                    LocalDate.of(2026, 9, 19),
                    88
            );

            createCompletedTask(
                    taskRepository,
                    employee2,
                    "Build Task Management UI",
                    "Create interface for displaying and managing assigned tasks.",
                    LocalDate.of(2026, 9, 26),
                    LocalDate.of(2026, 9, 27),
                    85
            );

            createCompletedTask(
                    taskRepository,
                    employee2,
                    "Improve Dashboard Responsiveness",
                    "Optimize dashboard layout for desktop and tablet screens.",
                    LocalDate.of(2026, 9, 30),
                    LocalDate.of(2026, 9, 30),
                    90
            );

            // =====================================================
            // EMPLOYEE 3 TASKS
            // =====================================================

            createCompletedTask(
                    taskRepository,
                    employee3,
                    "Write Login Test Cases",
                    "Prepare functional and negative test cases for login.",
                    LocalDate.of(2026, 9, 15),
                    LocalDate.of(2026, 9, 18),
                    72
            );

            createCompletedTask(
                    taskRepository,
                    employee3,
                    "Execute Regression Testing",
                    "Perform regression testing on the employee management module.",
                    LocalDate.of(2026, 9, 22),
                    LocalDate.of(2026, 9, 27),
                    65
            );

            createPendingTask(
                    taskRepository,
                    employee3,
                    "Prepare Final Test Report",
                    "Prepare final testing report and defect summary.",
                    LocalDate.of(2026, 9, 28)
            );

            // =====================================================
            // EMPLOYEE 4 TASKS
            // =====================================================

            createCompletedTask(
                    taskRepository,
                    employee4,
                    "Optimize Database Queries",
                    "Analyze slow queries and improve database performance.",
                    LocalDate.of(2026, 9, 20),
                    LocalDate.of(2026, 9, 21),
                    84
            );

            createCompletedTask(
                    taskRepository,
                    employee4,
                    "Create Database Backup",
                    "Configure and verify scheduled database backup.",
                    LocalDate.of(2026, 9, 24),
                    LocalDate.of(2026, 9, 24),
                    91
            );

            createCompletedTask(
                    taskRepository,
                    employee4,
                    "Database Documentation",
                    "Document important tables, relationships and database procedures.",
                    LocalDate.of(2026, 9, 29),
                    LocalDate.of(2026, 10, 1),
                    82
            );

            // =====================================================
// CALCULATE INITIAL PERFORMANCE
// =====================================================

double performance1 = performanceService.calculatePerformance(employee1.getId());
double performance2 = performanceService.calculatePerformance(employee2.getId());
double performance3 = performanceService.calculatePerformance(employee3.getId());
double performance4 = performanceService.calculatePerformance(employee4.getId());

// =====================================================
// AWARD INITIAL CREDITS
// =====================================================

creditService.awardCredits(employee1.getId(), performance1);
creditService.awardCredits(employee2.getId(), performance2);
creditService.awardCredits(employee3.getId(), performance3);
creditService.awardCredits(employee4.getId(), performance4);

System.out.println("Initial performance and credits calculated.");

            // =====================================================
            // COMPLETION MESSAGE
            // =====================================================

            System.out.println("==============================================");
            System.out.println("Sample data created successfully!");
            System.out.println("----------------------------------------------");
            System.out.println("Manager  : manager / manager123");
            System.out.println("Employee : employee1 / employee123");
            System.out.println("Employee : employee2 / employee123");
            System.out.println("Employee : employee3 / employee123");
            System.out.println("Employee : employee4 / employee123");
            System.out.println("==============================================");
        };
    }

    // =============================================================
    // CREATE COMPLETED TASK
    // =============================================================

    private void createCompletedTask(
            TaskRepository taskRepository,
            Employee employee,
            String title,
            String description,
            LocalDate deadline,
            LocalDate completionDate,
            double qualityScore) {

        Task task = new Task();

        task.setTitle(title);
        task.setDescription(description);
        task.setEmployee(employee);

        // Task was assigned 5 days before its deadline.
        task.setAssignedDate(deadline.minusDays(5));

        task.setDeadline(deadline);
        task.setCompletionDate(completionDate);
        task.setCompleted(true);
        task.setQualityScore(qualityScore);
        task.setCreatedAt(LocalDateTime.now());

        taskRepository.save(task);
    }

    // =============================================================
    // CREATE PENDING TASK
    // =============================================================

    private void createPendingTask(
            TaskRepository taskRepository,
            Employee employee,
            String title,
            String description,
            LocalDate deadline) {

        Task task = new Task();

        task.setTitle(title);
        task.setDescription(description);
        task.setEmployee(employee);

        // Task was assigned 5 days before its deadline.
        task.setAssignedDate(deadline.minusDays(5));
        
        task.setDeadline(deadline);
        task.setCompletionDate(null);
        task.setCompleted(false);
        task.setQualityScore(0.0);
        task.setCreatedAt(LocalDateTime.now());

        taskRepository.save(task);
    }
}