
.PHONY: install seed-test-users

seed-test-users:
	php artisan db:seed --class=TestUserSeeder

install:
	@if [ ! -f .env ]; then \
		cp .env.example .env; \
	fi
	composer install
	php artisan key:generate
	php artisan migrate --seed
	npm install
	npm run build
