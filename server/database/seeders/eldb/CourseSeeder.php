<?php

namespace Database\Seeders\ELDB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('courses')->insert([
            [
                'course_name' => 'Intro to Technology',
                'course_description' => 'In this course, you will explore the foundational concepts of technology, starting with an understanding of computer hardware and software. You will learn about basic networking principles, the internet, and the evolution of modern technologies like artificial intelligence, machine learning, and the Internet of Things (IoT). Designed for beginners, this course will guide you step-by-step in understanding the role of technology in our daily lives, its impact on various industries, and its future trends.',
                'course_price' => 100,
                'course_state' => true,
                'user_id' => 2,
            ],
            [
                'course_name' => 'Advanced Science',
                'course_description' => 'This course dives deep into complex scientific concepts across various fields such as quantum mechanics, general relativity, molecular biology, and environmental science. We will explore advanced theories in physics, examine the complexities of human biology and genetics, and investigate cutting-edge scientific research that is shaping the future of healthcare, energy production, and climate change mitigation. The course also highlights the interdisciplinary connections between science and its practical applications in industries like medicine, technology, and engineering.',
                'course_price' => 200,
                'course_state' => true,
                'user_id' => 2,
            ],
            [
                'course_name' => 'Health and Wellness',
                'course_description' => 'This comprehensive course covers various aspects of health and wellness, providing you with evidence-based tips for maintaining a balanced lifestyle. You will learn about proper nutrition, effective exercise regimens, mental health strategies, stress management, and sleep hygiene. The course will also discuss the science behind these practices, how they impact the body, and why they are essential for long-term health. Special attention is given to mental and emotional well-being, teaching you how to overcome stress, boost productivity, and develop healthy habits for a more fulfilling life.',
                'course_price' => 300,
                'course_state' => true,
                'user_id' => 2,
            ],
            [
                'course_name' => 'Web Development Basics',
                'course_description' => 'Learn the basics of web development, starting with an introduction to HTML, CSS, and JavaScript. The course will cover how web pages are structured, styled, and made interactive. You will build your first fully functional website from scratch, gaining hands-on experience with responsive design, user-friendly interfaces, and essential programming concepts. Additionally, we will discuss web accessibility, search engine optimization (SEO) basics, and the principles of front-end development, preparing you for the next steps in creating professional websites.',
                'course_price' => 150,
                'course_state' => true,
                'user_id' => 2,
            ],
            [
                'course_name' => 'Data Science and Analytics',
                'course_description' => 'This course will introduce you to the world of data science, from collecting and cleaning data to performing complex data analysis using Python and R. You will explore various methods of data visualization, statistical modeling, and machine learning algorithms that help solve real-world problems. Through practical exercises, you will learn how to apply these techniques to large datasets, uncover insights, and make data-driven decisions. The course will also cover ethical issues in data analysis and teach you the importance of data privacy and security.',
                'course_price' => 250,
                'course_state' => true,
                'user_id' => 2,
            ],
            [
                'course_name' => 'Digital Marketing Strategies',
                'course_description' => 'This course is designed to help you understand the fundamentals of digital marketing and its role in the modern business landscape. You will learn about content marketing, social media strategies, search engine optimization (SEO), email campaigns, and paid advertising. Through case studies and practical examples, we will explore how to build and execute digital marketing campaigns that increase brand visibility, attract customers, and drive conversions. The course also covers analytics and tracking tools to measure the success of your campaigns and optimize them for better performance.',
                'course_price' => 180,
                'course_state' => true,
                'user_id' => 2,
            ],
            [
                'course_name' => 'Photography and Image Editing',
                'course_description' => 'This course will guide you through the fundamentals of photography, including camera settings, composition, and lighting techniques. You will learn how to capture high-quality photos in various environments, from indoor portraiture to outdoor landscapes. In addition, we will dive into image editing using tools like Adobe Photoshop and Lightroom, teaching you how to enhance your photos, remove imperfections, and create stunning visual effects. Whether you are a beginner or looking to refine your skills, this course will help you develop both technical and creative photography skills.',
                'course_price' => 220,
                'course_state' => true,
                'user_id' => 2,
            ],
            [
                'course_name' => 'Financial Management for Beginners',
                'course_description' => 'This course will teach you the basics of financial management, focusing on budgeting, saving, investing, and managing debt. You will gain a clear understanding of how personal finances work and learn practical strategies to make informed financial decisions. The course also includes an introduction to financial planning, retirement savings, and tax strategies. By the end of the course, you will have the knowledge and tools to take control of your financial future and make decisions that contribute to long-term financial stability and growth.',
                'course_price' => 120,
                'course_state' => true,
                'user_id' => 2,
            ],
            [
                'course_name' => 'Introduction to Artificial Intelligence',
                'course_description' => 'In this introductory course, you will explore the fundamentals of artificial intelligence (AI), including machine learning, neural networks, and deep learning. You will learn about the key concepts behind AI algorithms, and how these algorithms are used to solve complex problems in areas such as healthcare, robotics, and natural language processing. The course will also cover ethical considerations in AI, such as bias in algorithms and the potential impact of AI on employment and privacy. This is the perfect starting point for anyone interested in the field of AI.',
                'course_price' => 300,
                'course_state' => true,
                'user_id' => 2,
            ],
            [
                'course_name' => 'Business Leadership and Management',
                'course_description' => 'This course is aimed at developing leadership and management skills that are essential for running successful businesses. You will learn how to lead teams, make effective decisions, resolve conflicts, and create a culture of innovation. Topics such as strategic planning, organizational behavior, project management, and change management will be covered in-depth, along with practical tools for managing day-to-day operations. The course will also highlight real-life case studies of successful leaders and businesses, giving you insights into effective leadership strategies.',
                'course_price' => 350,
                'course_state' => true,
                'user_id' => 2,
            ]
        ]);
    }
}
