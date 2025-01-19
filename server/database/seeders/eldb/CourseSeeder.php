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
                'short_description' => 'Step into the exciting realm of technology and uncover how computers, networks, and innovations shape the world we live in today and tomorrow.',
                'long_description' => "
# Introduction

## Step into the exciting world of technology and embark on a journey to understand how it powers our modern lives.

*This course introduces key concepts such as:*

### 1. The inner workings of computer hardware and software

Understanding the **hardware** components of computers and how software drives their operations.

### 2. Basics of networking and the internet

Learn about the fundamentals of computer networking and how the internet connects the world.

### 3. Emerging trends

- **Artificial Intelligence (AI)**: How AI is revolutionizing industries and everyday life.
- **The Internet of Things (IoT)**: Connecting devices and systems for smarter living.

## What You’ll Learn

- How technology drives modern industries and economies.
- How to stay up to date with the rapid advancements in tech.
- A strong foundation in the basics of computer science, networking, and innovation.

### Example of Code Usage

```python
def greet_user(name):
    return f\"Hello, {name}!\"
```

> \"The future belongs to those who understand technology today.\" – **Jane Smith**, Instructor

[Learn More](https://www.example.com)

### Course Information

| **Key Aspect**     | **Details**                                                                 |
|--------------------|-----------------------------------------------------------------------------|
| **Course Duration**| **6 weeks** - An intensive and immersive course with hands-on projects.      |
| **Course Price**   | **500,000 VND** - Affordable tech education tailored for beginners.          |
| **Instructor**     | **Jane Smith** - A seasoned technology expert with over 10 years of experience. |
| **Contact**        | **jane@example.com** - Feel free to reach out for queries or assistance.    |
| **Course Location**| **Online** - Learn from anywhere, at your own pace.                         |
| **Certification**  | Receive a **Certificate of Completion** to showcase your achievement.       |
| **Special Feature**| **Hands-on labs** and a **final project** to solidify learning and skills.  |

---

Ready to dive in? Join today!
                ",
                'course_duration' => '6 weeks',
                'course_price' => 500000,
                'course_state' => true,
                'user_id' => 2,
            ],
            [
                'course_name' => 'Advanced Science',
                'short_description' => 'Explore the frontiers of modern science, diving deep into physics, biology, and the groundbreaking discoveries shaping the future of humanity.',
                'long_description' => "This course is designed for those ready to dive deep into the wonders of science:\n"
                    . "- Explore quantum mechanics and its impact on modern technology.\n"
                    . "- Understand the complexities of molecular biology and genetic research.\n"
                    . "- Investigate general relativity and its application in astrophysics.\n\n"
                    . "Throughout this course, you'll engage with real-world case studies, collaborative projects, and discussions about how scientific innovations transform industries and our daily lives.",
                'course_duration' => '10 weeks',
                'course_price' => 1200000,
                'course_state' => true,
                'user_id' => 2,
            ],
            [
                'course_name' => 'Health and Wellness',
                'short_description' => 'Unlock the secrets to living a healthier life with expert guidance on nutrition, effective exercise routines, and stress management techniques.',
                'long_description' => "Your health journey starts here. This course covers:\n"
                    . "- Building balanced and sustainable meal plans to suit your lifestyle.\n"
                    . "- Developing effective exercise routines for all fitness levels.\n"
                    . "- Mastering stress management and mindfulness techniques.\n\n"
                    . "Each session is packed with practical advice and actionable steps to help you prioritize your well-being and achieve your health goals.",
                'course_duration' => '8 weeks',
                'course_price' => 2000000,
                'course_state' => true,
                'user_id' => 2,
            ],
            [
                'course_name' => 'Web Development Basics',
                'short_description' => 'Learn how to build beautiful and functional websites using HTML, CSS, and JavaScript, even if you have no prior coding experience.',
                'long_description' => "Discover the art of web development in this beginner-friendly course:\n"
                    . "- Learn to craft elegant and functional web pages using HTML and CSS.\n"
                    . "- Make your websites interactive with JavaScript fundamentals.\n"
                    . "- Dive into responsive design principles to ensure your site looks great on any device.\n\n"
                    . "Through practical projects, you'll gain confidence in creating professional, user-friendly websites that stand out.",
                'course_duration' => '5 weeks',
                'course_price' => 800000,
                'course_state' => true,
                'user_id' => 2,
            ],
            [
                'course_name' => 'Digital Marketing Strategies',
                'short_description' => 'Master the art of digital marketing with hands-on strategies in SEO, social media, email campaigns, and content creation.',
                'long_description' => "Take your marketing skills to the next level with this in-depth course:\n"
                    . "- Understand how to optimize content for search engines (SEO).\n"
                    . "- Build effective social media strategies to engage your audience.\n"
                    . "- Create and analyze email campaigns that drive conversions.\n\n"
                    . "Whether you're an entrepreneur or marketing professional, this course will equip you with the tools and knowledge to succeed in the ever-changing digital landscape.",
                'course_duration' => '7 weeks',
                'course_price' => 1500000,
                'course_state' => true,
                'user_id' => 2,
            ],
        ]);
    }
}
