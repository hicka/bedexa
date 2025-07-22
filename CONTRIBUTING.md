# Contributing to Bedexa

Thank you for your interest in contributing to Bedexa! We welcome community involvement and appreciate your time and expertise.

## 📖 Getting Started

1. **Fork** the repository: Click the “Fork” button in the top-right.
2. **Clone** your fork locally:
   ```bash
   git clone https://github.com/hicka/bedexa.git
   cd bedexa
   ```
3. **Install dependencies**:
   ```bash
   composer install
   npm install && npm run dev
   ```
4. **Create an environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
5. **Run migrations and seeders**:
   ```bash
   php artisan migrate --seed
   ```

## 🛠 Development Workflow

1. **Branch**: Create a new branch for your work.
   ```bash
   git checkout -b feature/your-feature-name
   ```
2. **Code**: Make your changes, ensuring you follow existing patterns and conventions.
3. **Test**: Write or update tests when applicable and verify everything passes:
   ```bash
   php artisan test
   ```
4. **Commit**: Use [Conventional Commits](https://www.conventionalcommits.org/):
   ```bash
   feat(room): add new bulk-update action
   ```
5. **Push** to your fork:
   ```bash
   git push origin feature/your-feature-name
   ```
6. **Open a Pull Request** against the `main` branch of the upstream repo.

## 📋 Pull Request Guidelines

- **Descriptive title & summary**: Explain the problem and your solution.
- **Link issues**: Include `Closes #123` or `Fixes #456` when relevant.
- **Small, focused commits**: One feature or fix per PR.
- **Code style**: Follow PSR-12, Tailwind utility classes, and existing project style.
- **Tests**: Ensure new functionality is covered by tests.

## 📝 Style Guide

- **PHP**: PSR-12; prefer expressive naming, strict types, and type hints.
- **JavaScript**: Vanilla or Alpine.js (no additional frameworks), ES6+.

## 🐛 Reporting Issues

- **Search**: Check open and closed issues first.
- **New issue**: Provide a clear title, steps to reproduce, expected vs. actual behavior, and relevant logs or screenshots.

## 🤝 Code of Conduct

Please read and follow our [Code of Conduct](CODE_OF_CONDUCT.md) to keep the community respectful and welcoming.

---

Thank you for helping make Bedexa better!
