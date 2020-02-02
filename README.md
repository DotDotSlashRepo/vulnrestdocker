# Vulnerable PHP REST Webservice built with Docker Compose

![Landing Page](https://github.com/DotDotSlashRepo/vulnrestdocker/blob/master/images/image.PNG?raw=true)

A basic Shopping application in LAMP stack environment built using Docker Compose. Application is configured to have vulnerabilities including:

* SQL Injection
* Cross Site Scripting
* CORS Misconfiguration

## Installation

Clone this repository on your local computer.
Run the `docker-compose up -d`.

```shell
git clone https://github.com/DotDotSlashRepo/vulnrestdocker.git
cd vulnrestdocker/
cp sample.env .env
docker-compose up -d
```

Vulnerable webservice should be up and running now!! You can access it via `http://localhost:8082`.

## Credits

* Docker Lamp environment - https://github.com/sprintcube/docker-compose-lamp
* Original API Code - https://github.com/sambhavsharma/RESTful-API-PHP

## TODO

* Add JWT support
* Add SSRF vulnerability
