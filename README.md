Installation
------------

Directory <strong>"docker"</strong>:
``` bash
docker-compose build
docker-compose up -d
docker exec -it project_php composer install
```

Tests
------------
``` bash
docker exec -it project_php composer test
```

Api documentation
------------
``` bash
http://localhost:8080/api/doc
```

Missing
------------
<ul>
    <li>Error message handling - DTO validation and github api response</li>
    <li>Complete test coverage</li>
    <li>Api doc - DTO schema</li>
</ul>