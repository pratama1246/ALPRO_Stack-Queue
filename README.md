# 🎮 Sistem Manajemen Turnamen E-Sport Berbasis Struktur Data

A web-based e-sport tournament management system that demonstrates the practical implementation of **Stack** and **Queue** data structures using native PHP and PHP Sessions — built as a midterm project for the Data Structure Programming course at Politeknik Negeri Cilacap.

---

## 📌 Overview

This project applies two fundamental data structures in a real-world simulation context:

| Data Structure | Use Case |
|---------------|----------|
| **Stack** (LIFO) | Team strategy management with push, pop (undo), and print operations |
| **Queue** (FIFO) | Match scheduling — teams are queued and called in order |

The system is session-based, meaning all stack and queue data persist across page interactions using PHP's native `$_SESSION`.

---

## ✨ Features

### 🃏 Stack — Team Strategy Input
- **Push**: Add a team name and their strategy to the stack
- **Undo**: Pop the last entered strategy (LIFO behavior)
- **Print**: Display all strategies currently in the stack
- **Reset**: Clear all strategy data from the session

### 📋 Queue — Match Scheduling
- **Enqueue**: Register a team from the strategy list into the match queue
- **Dequeue (Panggil Tim)**: Call the next team in line (FIFO behavior)
- **Display Queue**: View all teams currently waiting in the queue
- **Reset**: Clear all queue data from the session

### 🔔 Flash Notification System
- Real-time feedback messages displayed after each action (add, undo, call, reset)
- Messages are stored in session and cleared after display

---

## 🧰 Tech Stack

| Layer | Technology |
|-------|-----------|
| Language | PHP (Native, no framework) |
| State Management | PHP Session (`$_SESSION`) |
| Frontend | HTML, CSS (custom) |
| Server | Apache / PHP Built-in Server |

---

## 📁 Project Structure

```
ALPRO_Stack-Queue/
├── index.php     # Main page — entry point, form UI, flash notifications
├── stack.php     # Stack logic — push, pop (undo), print, reset
├── queue.php     # Queue logic — enqueue, dequeue, display, reset
└── style.css     # Custom styling
```

---

## ⚙️ How to Run

### Requirements
- PHP >= 7.4
- Web server (XAMPP, Laragon, or PHP built-in server)

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/pratama1246/ALPRO_Stack-Queue.git
   cd ALPRO_Stack-Queue
   ```

2. **Run with PHP built-in server**
   ```bash
   php -S localhost:8080
   ```

3. **Or place in XAMPP/Laragon `htdocs` folder**, then open:
   ```
   http://localhost/ALPRO_Stack-Queue/
   ```

---

## 🧠 Data Structure Concepts Applied

### Stack (stack.php)
```
Push  → $_SESSION['stack']['data'][] = ['tim' => ..., 'strategi' => ...]
Pop   → array_pop($_SESSION['stack']['data'])
Print → iterate $_SESSION['stack']['data']
```

### Queue (queue.php)
```
Enqueue  → $_SESSION['queue'][] = $tim
Dequeue  → array_shift($_SESSION['queue'])
Display  → iterate $_SESSION['queue']
```

---

## 👥 Team

| No | Name | NIM |
|----|------|-----|
| 1 | Aliyya Fadhilah | 240102097 |
| 2 | Amelia Nur Hamda Rina | 240102098 |
| 3 | Nuke Zahra Alifia | 240302113 |
| 4 | Panji Parisya Akmal Hoetomo | 240202114 |
| 5 | Pratama Putra Purwanto | 240202115 |

**Class:** Teknik Informatika 1D  
**Course:** Pemrograman Struktur Data (Stack & Queue)   
**Institution:** Politeknik Negeri Cilacap

---

## 📄 License

This project is open for educational reference. No license applied.
