# Refactoring of commission calculation logic

The refactored code employs a CommissionCalculator class
that accepts implementations of BinProvider, CurrencyRatesProvider 
and CountryChecker interfaces to fetch BIN information, 
currency exchange rates and check EU country respectively.

Also added docker to run the environment

_Refactoring time: ~3.5 hours_

Original code is in `main` branch in index.php

###Steps to run and use docker

1. Run the following command in the project directory to build the Docker image:
```
docker build -t php-comission-app .
```

2. Run the Docker container to execute the PHPUnit tests:
```
docker run --rm -it php-comission-app
```
3. If you want to run your index.php code inside the container, you can do the following
```
docker run --rm -it php-comission-app php index.php input.txt
```
4. To keep the container running and interact with it, you can start an interactive shell session inside the container:
```
docker run -it --rm -v /path/to/your/project:/app php-comission-app bash
```
Replace `/path/to/your/project` with the actual path to your project directory on your host machine


