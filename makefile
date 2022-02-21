commit:
	@ddev exec 'git add $f'
	ddev exec 'git commit -m "$m"'
install:
	ddev start && ddev composer install && ddev exec 'npm install' && ddev exec 'yarn build' && ddev exec 'bin/console doctrine:migrations:migrate --no-interaction'
create-user:
    ddev exec 'php bin/console user:create'