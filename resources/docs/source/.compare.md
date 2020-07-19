---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost:8844/docs/collection.json)

<!-- END_INFO -->

#Users


<!-- START_fc1e4f6a697e3c48257de845299b71d5 -->
## Get users

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/api/users?include[permissions]=permissions&include[roles]=roles&page[number]=1&page[size]=3" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api/users"
);

let params = {
    "include[permissions]": "permissions",
    "include[roles]": "roles",
    "page[number]": "1",
    "page[size]": "3",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "id": 1,
            "username": "admin",
            "name": "Admin",
            "email": "admin@example.org",
            "created_at": "2020-07-19T21:40:43.000000Z",
            "updated_at": "2020-07-19T21:40:43.000000Z",
            "permissions": [],
            "roles": [
                {
                    "id": 1,
                    "name": "admin",
                    "display_name": "Administrator"
                }
            ]
        },
        {
            "id": 2,
            "username": "ebert.nikki",
            "name": "Laurence Bruen II",
            "email": "camden.larson@example.net",
            "created_at": "2020-07-19T21:40:44.000000Z",
            "updated_at": "2020-07-19T21:40:44.000000Z",
            "permissions": [],
            "roles": []
        },
        {
            "id": 3,
            "username": "ricky75",
            "name": "Ms. Mallie McCullough PhD",
            "email": "ghowell@example.com",
            "created_at": "2020-07-19T21:40:44.000000Z",
            "updated_at": "2020-07-19T21:40:44.000000Z",
            "permissions": [],
            "roles": []
        }
    ],
    "links": {
        "first": "http:\/\/localhost\/api\/users?include%5Bpermissions%5D=permissions&include%5Broles%5D=roles&page%5Bsize%5D=3&page%5Bnumber%5D=1",
        "last": "http:\/\/localhost\/api\/users?include%5Bpermissions%5D=permissions&include%5Broles%5D=roles&page%5Bsize%5D=3&page%5Bnumber%5D=5",
        "prev": null,
        "next": "http:\/\/localhost\/api\/users?include%5Bpermissions%5D=permissions&include%5Broles%5D=roles&page%5Bsize%5D=3&page%5Bnumber%5D=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 5,
        "path": "http:\/\/localhost\/api\/users",
        "per_page": 3,
        "to": 3,
        "total": 13
    }
}
```

### HTTP Request
`GET api/users`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `filter[field:eq]` |  optional  | Equals for field: <b>id, username, name, roles.id</b>
    `filter[field:gt]` |  optional  | Greater than for field: <b>id, created_at, updated_at</b>
    `filter[field:gte]` |  optional  | Greater than or equal for field: <b>id, created_at, updated_at</b>
    `filter[field:has]` |  optional  | Has value for field: <b>username, name, roles.id</b>
    `filter[field:like]` |  optional  | Fuzzy search for field: <b>username, name, email</b>
    `filter[field:lt]` |  optional  | Less than for field: <b>id, created_at, updated_at</b>
    `filter[field:lte]` |  optional  | Less than or equal for field: <b>id, created_at, updated_at</b>
    `filter[like]` |  optional  | Fuzzy search for fields: <b>username, name, email</b>
    `include[permissions]` |  optional  | Include relation: permissions
    `include[roles]` |  optional  | Include relation: roles
    `page[number]` |  optional  | Pagination page number
    `page[size]` |  optional  | Pagination number of results
    `sort` |  optional  | Sort by fields: (id, username, name, email). Prepend with - to sort descending. Separate multiple fields with a comma.

<!-- END_fc1e4f6a697e3c48257de845299b71d5 -->

<!-- START_8653614346cb0e3d444d164579a0a0a2 -->
## Get a user

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/api/users/delectus" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api/users/delectus"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (404):

```json
{
    "errors": "No query results for model [App\\Users\\Models\\User] delectus"
}
```

### HTTP Request
`GET api/users/{user}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `user` |  required  | The user id

<!-- END_8653614346cb0e3d444d164579a0a0a2 -->

<!-- START_d2db7a9fe3abd141d5adbc367a88e969 -->
## Delete a user

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost:8844/api/users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api/users/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/users/{user}`


<!-- END_d2db7a9fe3abd141d5adbc367a88e969 -->

<!-- START_09a889ad3c7b5434f4d3fd3d31a924c3 -->
## Delete users

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X DELETE \
    "http://localhost:8844/api/users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":"facere"}'

```

```javascript
const url = new URL(
    "http://localhost:8844/api/users"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": "facere"
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/users`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `ids` | string |  required  | 
    
<!-- END_09a889ad3c7b5434f4d3fd3d31a924c3 -->

#general


<!-- START_4b90f657df4927ac7a249b99226ea7e1 -->
## Get the index of a given version.

> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/docs/search-index/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/docs/search-index/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (403):

```json
{
    "message": ""
}
```

### HTTP Request
`GET docs/search-index/{version}`


<!-- END_4b90f657df4927ac7a249b99226ea7e1 -->

<!-- START_568f07577ee68f8b1116e97fd4a5d842 -->
## docs/styles/{style}
> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/docs/styles/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/docs/styles/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET docs/styles/{style}`


<!-- END_568f07577ee68f8b1116e97fd4a5d842 -->

<!-- START_7cdb95077f4d2842f8268003be0400e6 -->
## docs/scripts/{script}
> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/docs/scripts/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/docs/scripts/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET docs/scripts/{script}`


<!-- END_7cdb95077f4d2842f8268003be0400e6 -->

<!-- START_b49197dda1e390d1c17aa2d177702247 -->
## Redirect the index page of docs to the default version.

> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/docs" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/docs"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (302):

```json
null
```

### HTTP Request
`GET docs`


<!-- END_b49197dda1e390d1c17aa2d177702247 -->

<!-- START_9befedf0e2960c8902af7f03e63fbcb2 -->
## Show a documentation page.

> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/docs/1/" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/docs/1/"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (404):

```json
null
```

### HTTP Request
`GET docs/{version}/{page?}`


<!-- END_9befedf0e2960c8902af7f03e63fbcb2 -->

<!-- START_cd4a874127cd23508641c63b640ee838 -->
## doc.json
> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/doc.json" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/doc.json"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "variables": [],
    "info": {
        "name": "Blue API",
        "_postman_id": "d57f4f5c-e24a-446c-86af-dc5855a1573e",
        "description": "",
        "schema": "https:\/\/schema.getpostman.com\/json\/collection\/v2.0.0\/collection.json"
    },
    "item": [
        {
            "name": "Users",
            "description": "",
            "item": [
                {
                    "name": "Get users",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/users",
                            "query": [
                                {
                                    "key": "filter[field:eq]",
                                    "value": "",
                                    "description": "Equals for field: <b>id, username, name, roles.id<\/b>",
                                    "disabled": true
                                },
                                {
                                    "key": "filter[field:gt]",
                                    "value": "",
                                    "description": "Greater than for field: <b>id, created_at, updated_at<\/b>",
                                    "disabled": true
                                },
                                {
                                    "key": "filter[field:gte]",
                                    "value": "",
                                    "description": "Greater than or equal for field: <b>id, created_at, updated_at<\/b>",
                                    "disabled": true
                                },
                                {
                                    "key": "filter[field:has]",
                                    "value": "",
                                    "description": "Has value for field: <b>username, name, roles.id<\/b>",
                                    "disabled": true
                                },
                                {
                                    "key": "filter[field:like]",
                                    "value": "",
                                    "description": "Fuzzy search for field: <b>username, name, email<\/b>",
                                    "disabled": true
                                },
                                {
                                    "key": "filter[field:lt]",
                                    "value": "",
                                    "description": "Less than for field: <b>id, created_at, updated_at<\/b>",
                                    "disabled": true
                                },
                                {
                                    "key": "filter[field:lte]",
                                    "value": "",
                                    "description": "Less than or equal for field: <b>id, created_at, updated_at<\/b>",
                                    "disabled": true
                                },
                                {
                                    "key": "filter[like]",
                                    "value": "",
                                    "description": "Fuzzy search for fields: <b>username, name, email<\/b>",
                                    "disabled": true
                                },
                                {
                                    "key": "include[permissions]",
                                    "value": "permissions",
                                    "description": "Include relation: permissions",
                                    "disabled": false
                                },
                                {
                                    "key": "include[roles]",
                                    "value": "roles",
                                    "description": "Include relation: roles",
                                    "disabled": false
                                },
                                {
                                    "key": "page[number]",
                                    "value": "1",
                                    "description": "Pagination page number",
                                    "disabled": false
                                },
                                {
                                    "key": "page[size]",
                                    "value": "3",
                                    "description": "Pagination number of results",
                                    "disabled": false
                                },
                                {
                                    "key": "sort",
                                    "value": "",
                                    "description": "Sort by fields: (id, username, name, email). Prepend with - to sort descending. Separate multiple fields with a comma.",
                                    "disabled": true
                                }
                            ]
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Get a user",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/users\/:user",
                            "query": [],
                            "variable": [
                                {
                                    "id": "user",
                                    "key": "user",
                                    "value": "explicabo",
                                    "description": "The user id"
                                }
                            ]
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Delete a user",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/users\/:user",
                            "query": []
                        },
                        "method": "DELETE",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Delete users",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/users",
                            "query": []
                        },
                        "method": "DELETE",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"ids\": \"voluptatem\"\n}"
                        },
                        "description": "",
                        "response": []
                    }
                }
            ]
        },
        {
            "name": "general",
            "description": "",
            "item": [
                {
                    "name": "Get the index of a given version.",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "docs\/search-index\/:version",
                            "query": []
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "docs\/styles\/{style}",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "docs\/styles\/:style",
                            "query": []
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "docs\/scripts\/{script}",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "docs\/scripts\/:script",
                            "query": []
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Redirect the index page of docs to the default version.",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "docs",
                            "query": []
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Show a documentation page.",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "docs\/:version\/:page",
                            "query": []
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "doc.json",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "doc.json",
                            "query": []
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "api\/admin",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/admin",
                            "query": []
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Base API route \"\/\"\nReturns the api schema",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api",
                            "query": []
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Get filtersets",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/filtersets",
                            "query": []
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Display the specified resource.",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/filtersets\/:filterset",
                            "query": []
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Remove the specified resource from storage.",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/filtersets\/:filterset",
                            "query": []
                        },
                        "method": "DELETE",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Remove the specified resources from storage.",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/filtersets",
                            "query": []
                        },
                        "method": "DELETE",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "User login attempt, generates JWT token",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/auth\/login",
                            "query": []
                        },
                        "method": "POST",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"email\": \"sit\",\n    \"password\": \"enim\"\n}"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "User logout, invalidates JWT token",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/auth\/logout",
                            "query": []
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Publicly registers a user.",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/auth\/register",
                            "query": []
                        },
                        "method": "POST",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"email\": \"occaecati\"\n}"
                        },
                        "description": "Workflow is:\nStore as new user with just email\nSend verify email\nVerify validates user account and captures new password and name\nUser can then login with password",
                        "response": []
                    }
                },
                {
                    "name": "Refresh JWT token",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/auth\/refresh",
                            "query": []
                        },
                        "method": "POST",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "api\/auth\/roles",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/auth\/roles",
                            "query": []
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Send reset password email to user",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/auth\/send-reset-password",
                            "query": []
                        },
                        "method": "POST",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"email\": \"enim\"\n}"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Returns the current user logged in or not status",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/auth\/status",
                            "query": []
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Display a listing of the resource.",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/messages\/contact-messages",
                            "query": []
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Store a contact message.",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/messages\/contact-messages",
                            "query": []
                        },
                        "method": "POST",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"email\": \"aliquid\",\n    \"name\": \"consequuntur\",\n    \"subject\": \"sit\",\n    \"message\": \"qui\"\n}"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Show a contact message.",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/messages\/contact-messages\/:contact_message",
                            "query": []
                        },
                        "method": "GET",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Update a contact message.",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/messages\/contact-messages\/:contact_message",
                            "query": []
                        },
                        "method": "PUT",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"email\": \"cupiditate\",\n    \"name\": \"laudantium\",\n    \"subject\": \"molestiae\",\n    \"message\": \"tenetur\"\n}"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Delete a contact message.",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/messages\/contact-messages\/:contact_message",
                            "query": []
                        },
                        "method": "DELETE",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "[]"
                        },
                        "description": "",
                        "response": []
                    }
                },
                {
                    "name": "Delete contact messages.",
                    "request": {
                        "url": {
                            "protocol": "http",
                            "host": "localhost:8844",
                            "path": "api\/messages\/contact-messages",
                            "query": []
                        },
                        "method": "DELETE",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application\/json"
                            },
                            {
                                "key": "Accept",
                                "value": "application\/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"ids\": \"unde\"\n}"
                        },
                        "description": "",
                        "response": []
                    }
                }
            ]
        }
    ]
}
```

### HTTP Request
`GET doc.json`


<!-- END_cd4a874127cd23508641c63b640ee838 -->

<!-- START_99a3c4dbe1d3c6031b4d1ac151ce6a20 -->
## api/admin
> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/api/admin" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api/admin"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/admin`


<!-- END_99a3c4dbe1d3c6031b4d1ac151ce6a20 -->

<!-- START_ae309226f6476a5c4acc7fb3419990bd -->
## Base API route &quot;/&quot;
Returns the api schema

> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/api" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
[]
```

### HTTP Request
`GET api`


<!-- END_ae309226f6476a5c4acc7fb3419990bd -->

<!-- START_e52c0d6b4edf8947c7e3600c90531739 -->
## Get filtersets

> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/api/filtersets" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api/filtersets"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [],
    "links": {
        "first": "http:\/\/localhost\/api\/filtersets?page%5Bnumber%5D=1",
        "last": "http:\/\/localhost\/api\/filtersets?page%5Bnumber%5D=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": null,
        "last_page": 1,
        "path": "http:\/\/localhost\/api\/filtersets",
        "per_page": 30,
        "to": null,
        "total": 0
    }
}
```

### HTTP Request
`GET api/filtersets`


<!-- END_e52c0d6b4edf8947c7e3600c90531739 -->

<!-- START_135eaf907d9f9f95763e73f551152091 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/api/filtersets/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api/filtersets/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/filtersets/{filterset}`


<!-- END_135eaf907d9f9f95763e73f551152091 -->

<!-- START_ba630c9d1416a266686c62f77db7890e -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE \
    "http://localhost:8844/api/filtersets/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api/filtersets/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/filtersets/{filterset}`


<!-- END_ba630c9d1416a266686c62f77db7890e -->

<!-- START_81f114bef7967dbf79e2130e3c73acaa -->
## Remove the specified resources from storage.

> Example request:

```bash
curl -X DELETE \
    "http://localhost:8844/api/filtersets" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api/filtersets"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/filtersets`


<!-- END_81f114bef7967dbf79e2130e3c73acaa -->

<!-- START_a925a8d22b3615f12fca79456d286859 -->
## User login attempt, generates JWT token

> Example request:

```bash
curl -X POST \
    "http://localhost:8844/api/auth/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"aut","password":"architecto"}'

```

```javascript
const url = new URL(
    "http://localhost:8844/api/auth/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "aut",
    "password": "architecto"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/auth/login`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | string |  required  | 
        `password` | string |  required  | 
    
<!-- END_a925a8d22b3615f12fca79456d286859 -->

<!-- START_16928cb8fc6adf2d9bb675d62a2095c5 -->
## User logout, invalidates JWT token

> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/api/auth/logout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api/auth/logout"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/auth/logout`


<!-- END_16928cb8fc6adf2d9bb675d62a2095c5 -->

<!-- START_2e1c96dcffcfe7e0eb58d6408f1d619e -->
## Publicly registers a user.

Workflow is:
Store as new user with just email
Send verify email
Verify validates user account and captures new password and name
User can then login with password

> Example request:

```bash
curl -X POST \
    "http://localhost:8844/api/auth/register" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"rerum"}'

```

```javascript
const url = new URL(
    "http://localhost:8844/api/auth/register"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "rerum"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/auth/register`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | string |  required  | 
    
<!-- END_2e1c96dcffcfe7e0eb58d6408f1d619e -->

<!-- START_994af8f47e3039ba6d6d67c09dd9e415 -->
## Refresh JWT token

> Example request:

```bash
curl -X POST \
    "http://localhost:8844/api/auth/refresh" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api/auth/refresh"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/auth/refresh`


<!-- END_994af8f47e3039ba6d6d67c09dd9e415 -->

<!-- START_65b6b5b61b3513f228f76bab268ff3be -->
## api/auth/roles
> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/api/auth/roles" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api/auth/roles"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": [
        {
            "id": 1,
            "name": "admin",
            "display_name": "Administrator",
            "description": "Site administrator",
            "created_at": "2020-07-19T21:40:43.000000Z",
            "updated_at": "2020-07-19T21:40:43.000000Z"
        },
        {
            "id": 2,
            "name": "editor",
            "display_name": "Editor",
            "description": "Editor",
            "created_at": "2020-07-19T21:40:43.000000Z",
            "updated_at": "2020-07-19T21:40:43.000000Z"
        }
    ]
}
```

### HTTP Request
`GET api/auth/roles`


<!-- END_65b6b5b61b3513f228f76bab268ff3be -->

<!-- START_ccf08e81e5a4ef81965e0a72d4f6dfd0 -->
## Send reset password email to user

> Example request:

```bash
curl -X POST \
    "http://localhost:8844/api/auth/send-reset-password" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"eum"}'

```

```javascript
const url = new URL(
    "http://localhost:8844/api/auth/send-reset-password"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "eum"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/auth/send-reset-password`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | string |  required  | 
    
<!-- END_ccf08e81e5a4ef81965e0a72d4f6dfd0 -->

<!-- START_ff5ea5d04f37d8fc0f8cf5f864772614 -->
## Returns the current user logged in or not status

> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/api/auth/status" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api/auth/status"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "id": null
    },
    "meta": []
}
```

### HTTP Request
`GET api/auth/status`


<!-- END_ff5ea5d04f37d8fc0f8cf5f864772614 -->

<!-- START_724dff539a355a83d6047ff0b83875a7 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/api/messages/contact-messages" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api/messages/contact-messages"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/messages/contact-messages`


<!-- END_724dff539a355a83d6047ff0b83875a7 -->

<!-- START_3f7fec5dff49f4ef1cf64db6ce6f7e26 -->
## Store a contact message.

> Example request:

```bash
curl -X POST \
    "http://localhost:8844/api/messages/contact-messages" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"voluptatibus","name":"molestiae","subject":"omnis","message":"pariatur"}'

```

```javascript
const url = new URL(
    "http://localhost:8844/api/messages/contact-messages"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "voluptatibus",
    "name": "molestiae",
    "subject": "omnis",
    "message": "pariatur"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/messages/contact-messages`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | string |  required  | 
        `name` | string |  required  | 
        `subject` | string |  required  | 
        `message` | string |  required  | 
    
<!-- END_3f7fec5dff49f4ef1cf64db6ce6f7e26 -->

<!-- START_178c5edf8496192ff4eb44ad3b32a427 -->
## Show a contact message.

> Example request:

```bash
curl -X GET \
    -G "http://localhost:8844/api/messages/contact-messages/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api/messages/contact-messages/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "id": 1,
        "subject": "Eaque dolore magnam minima deserunt qui qui.",
        "message": "Sed saepe animi mollitia ea quia sit facere. Id rerum ea nihil placeat in et. Incidunt qui possimus doloribus. Consequatur nihil in dolores culpa minus.",
        "name": "Pete Windler",
        "email": "virgie30@example.net",
        "created_at": "2020-07-19T21:40:44.000000Z",
        "updated_at": "2020-07-19T21:40:44.000000Z"
    }
}
```

### HTTP Request
`GET api/messages/contact-messages/{contact_message}`


<!-- END_178c5edf8496192ff4eb44ad3b32a427 -->

<!-- START_7e121161c79dd05ed2d1ac8d88791570 -->
## Update a contact message.

> Example request:

```bash
curl -X PUT \
    "http://localhost:8844/api/messages/contact-messages/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"explicabo","name":"sint","subject":"non","message":"quas"}'

```

```javascript
const url = new URL(
    "http://localhost:8844/api/messages/contact-messages/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "explicabo",
    "name": "sint",
    "subject": "non",
    "message": "quas"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/messages/contact-messages/{contact_message}`

`PATCH api/messages/contact-messages/{contact_message}`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | string |  required  | 
        `name` | string |  required  | 
        `subject` | string |  required  | 
        `message` | string |  required  | 
    
<!-- END_7e121161c79dd05ed2d1ac8d88791570 -->

<!-- START_55559957f6dcd256c20a4048d75c850a -->
## Delete a contact message.

> Example request:

```bash
curl -X DELETE \
    "http://localhost:8844/api/messages/contact-messages/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost:8844/api/messages/contact-messages/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/messages/contact-messages/{contact_message}`


<!-- END_55559957f6dcd256c20a4048d75c850a -->

<!-- START_729ee6662e8cc5275945e42496d2552c -->
## Delete contact messages.

> Example request:

```bash
curl -X DELETE \
    "http://localhost:8844/api/messages/contact-messages" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":"aut"}'

```

```javascript
const url = new URL(
    "http://localhost:8844/api/messages/contact-messages"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": "aut"
}

fetch(url, {
    method: "DELETE",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/messages/contact-messages`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `ids` | string |  required  | 
    
<!-- END_729ee6662e8cc5275945e42496d2552c -->


