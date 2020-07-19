<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>API Reference</title>

    <link rel="stylesheet" href="{{ asset('/docs/css/style.css') }}" />
    <script src="{{ asset('/docs/js/all.js') }}"></script>


          <script>
        $(function() {
            setupLanguages(["bash","javascript"]);
        });
      </script>
      </head>

  <body class="">
    <a href="#" id="nav-button">
      <span>
        NAV
        <img src="/docs/images/navbar.png" />
      </span>
    </a>
    <div class="tocify-wrapper">
        <img src="/docs/images/logo.png" />
                    <div class="lang-selector">
                                  <a href="#" data-language-name="bash">bash</a>
                                  <a href="#" data-language-name="javascript">javascript</a>
                            </div>
                            <div class="search">
              <input type="text" class="search" id="input-search" placeholder="Search">
            </div>
            <ul class="search-results"></ul>
              <div id="toc">
      </div>
                    <ul class="toc-footer">
                                  <li><a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a></li>
                            </ul>
            </div>
    <div class="page-wrapper">
      <div class="dark-box"></div>
      <div class="content">
          <!-- START_INFO -->
<h1>Info</h1>
<p>Welcome to the generated API reference.
<a href="{{ route("apidoc.json") }}">Get Postman Collection</a></p>
<!-- END_INFO -->
<h1>Users</h1>
<!-- START_fc1e4f6a697e3c48257de845299b71d5 -->
<h2>Get users</h2>
<p><br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/api/users?include[permissions]=permissions&amp;include[roles]=roles&amp;page[number]=1&amp;page[size]=3" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
    "http://localhost:8844/api/users"
);

let params = {
    "include[permissions]": "permissions",
    "include[roles]": "roles",
    "page[number]": "1",
    "page[size]": "3",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
        "first": "http:\/\/localhost\/api\/users?include%5Bpermissions%5D=permissions&amp;include%5Broles%5D=roles&amp;page%5Bsize%5D=3&amp;page%5Bnumber%5D=1",
        "last": "http:\/\/localhost\/api\/users?include%5Bpermissions%5D=permissions&amp;include%5Broles%5D=roles&amp;page%5Bsize%5D=3&amp;page%5Bnumber%5D=5",
        "prev": null,
        "next": "http:\/\/localhost\/api\/users?include%5Bpermissions%5D=permissions&amp;include%5Broles%5D=roles&amp;page%5Bsize%5D=3&amp;page%5Bnumber%5D=2"
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/users</code></p>
<h4>Query Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>filter[field:eq]</code></td>
<td>optional</td>
<td>Equals for field: <b>id, username, name, roles.id</b></td>
</tr>
<tr>
<td><code>filter[field:gt]</code></td>
<td>optional</td>
<td>Greater than for field: <b>id, created_at, updated_at</b></td>
</tr>
<tr>
<td><code>filter[field:gte]</code></td>
<td>optional</td>
<td>Greater than or equal for field: <b>id, created_at, updated_at</b></td>
</tr>
<tr>
<td><code>filter[field:has]</code></td>
<td>optional</td>
<td>Has value for field: <b>username, name, roles.id</b></td>
</tr>
<tr>
<td><code>filter[field:like]</code></td>
<td>optional</td>
<td>Fuzzy search for field: <b>username, name, email</b></td>
</tr>
<tr>
<td><code>filter[field:lt]</code></td>
<td>optional</td>
<td>Less than for field: <b>id, created_at, updated_at</b></td>
</tr>
<tr>
<td><code>filter[field:lte]</code></td>
<td>optional</td>
<td>Less than or equal for field: <b>id, created_at, updated_at</b></td>
</tr>
<tr>
<td><code>filter[like]</code></td>
<td>optional</td>
<td>Fuzzy search for fields: <b>username, name, email</b></td>
</tr>
<tr>
<td><code>include[permissions]</code></td>
<td>optional</td>
<td>Include relation: permissions</td>
</tr>
<tr>
<td><code>include[roles]</code></td>
<td>optional</td>
<td>Include relation: roles</td>
</tr>
<tr>
<td><code>page[number]</code></td>
<td>optional</td>
<td>Pagination page number</td>
</tr>
<tr>
<td><code>page[size]</code></td>
<td>optional</td>
<td>Pagination number of results</td>
</tr>
<tr>
<td><code>sort</code></td>
<td>optional</td>
<td>Sort by fields: (id, username, name, email). Prepend with - to sort descending. Separate multiple fields with a comma.</td>
</tr>
</tbody>
</table>
<!-- END_fc1e4f6a697e3c48257de845299b71d5 -->
<!-- START_8653614346cb0e3d444d164579a0a0a2 -->
<h2>Get a user</h2>
<p><br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/api/users/delectus" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">{
    "errors": "No query results for model [App\\Users\\Models\\User] delectus"
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/users/{user}</code></p>
<h4>URL Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>user</code></td>
<td>required</td>
<td>The user id</td>
</tr>
</tbody>
</table>
<!-- END_8653614346cb0e3d444d164579a0a0a2 -->
<!-- START_d2db7a9fe3abd141d5adbc367a88e969 -->
<h2>Delete a user</h2>
<p><br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://localhost:8844/api/users/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>DELETE api/users/{user}</code></p>
<!-- END_d2db7a9fe3abd141d5adbc367a88e969 -->
<!-- START_09a889ad3c7b5434f4d3fd3d31a924c3 -->
<h2>Delete users</h2>
<p><br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small></p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://localhost:8844/api/users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":"facere"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>DELETE api/users</code></p>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>ids</code></td>
<td>string</td>
<td>required</td>
</tr>
</tbody>
</table>
<!-- END_09a889ad3c7b5434f4d3fd3d31a924c3 -->
<h1>general</h1>
<!-- START_4b90f657df4927ac7a249b99226ea7e1 -->
<h2>Get the index of a given version.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/docs/search-index/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (403):</p>
</blockquote>
<pre><code class="language-json">{
    "message": ""
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET docs/search-index/{version}</code></p>
<!-- END_4b90f657df4927ac7a249b99226ea7e1 -->
<!-- START_568f07577ee68f8b1116e97fd4a5d842 -->
<h2>docs/styles/{style}</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/docs/styles/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (500):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Server Error"
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET docs/styles/{style}</code></p>
<!-- END_568f07577ee68f8b1116e97fd4a5d842 -->
<!-- START_7cdb95077f4d2842f8268003be0400e6 -->
<h2>docs/scripts/{script}</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/docs/scripts/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (500):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Server Error"
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET docs/scripts/{script}</code></p>
<!-- END_7cdb95077f4d2842f8268003be0400e6 -->
<!-- START_b49197dda1e390d1c17aa2d177702247 -->
<h2>Redirect the index page of docs to the default version.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/docs" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (302):</p>
</blockquote>
<pre><code class="language-json">null</code></pre>
<h3>HTTP Request</h3>
<p><code>GET docs</code></p>
<!-- END_b49197dda1e390d1c17aa2d177702247 -->
<!-- START_9befedf0e2960c8902af7f03e63fbcb2 -->
<h2>Show a documentation page.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/docs/1/" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (404):</p>
</blockquote>
<pre><code class="language-json">null</code></pre>
<h3>HTTP Request</h3>
<p><code>GET docs/{version}/{page?}</code></p>
<!-- END_9befedf0e2960c8902af7f03e63fbcb2 -->
<!-- START_cd4a874127cd23508641c63b640ee838 -->
<h2>doc.json</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/doc.json" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
                                    "description": "Equals for field: &lt;b&gt;id, username, name, roles.id&lt;\/b&gt;",
                                    "disabled": true
                                },
                                {
                                    "key": "filter[field:gt]",
                                    "value": "",
                                    "description": "Greater than for field: &lt;b&gt;id, created_at, updated_at&lt;\/b&gt;",
                                    "disabled": true
                                },
                                {
                                    "key": "filter[field:gte]",
                                    "value": "",
                                    "description": "Greater than or equal for field: &lt;b&gt;id, created_at, updated_at&lt;\/b&gt;",
                                    "disabled": true
                                },
                                {
                                    "key": "filter[field:has]",
                                    "value": "",
                                    "description": "Has value for field: &lt;b&gt;username, name, roles.id&lt;\/b&gt;",
                                    "disabled": true
                                },
                                {
                                    "key": "filter[field:like]",
                                    "value": "",
                                    "description": "Fuzzy search for field: &lt;b&gt;username, name, email&lt;\/b&gt;",
                                    "disabled": true
                                },
                                {
                                    "key": "filter[field:lt]",
                                    "value": "",
                                    "description": "Less than for field: &lt;b&gt;id, created_at, updated_at&lt;\/b&gt;",
                                    "disabled": true
                                },
                                {
                                    "key": "filter[field:lte]",
                                    "value": "",
                                    "description": "Less than or equal for field: &lt;b&gt;id, created_at, updated_at&lt;\/b&gt;",
                                    "disabled": true
                                },
                                {
                                    "key": "filter[like]",
                                    "value": "",
                                    "description": "Fuzzy search for fields: &lt;b&gt;username, name, email&lt;\/b&gt;",
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET doc.json</code></p>
<!-- END_cd4a874127cd23508641c63b640ee838 -->
<!-- START_99a3c4dbe1d3c6031b4d1ac151ce6a20 -->
<h2>api/admin</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/api/admin" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (500):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Server Error"
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/admin</code></p>
<!-- END_99a3c4dbe1d3c6031b4d1ac151ce6a20 -->
<!-- START_ae309226f6476a5c4acc7fb3419990bd -->
<h2>Base API route &quot;/&quot;</h2>
<p>Returns the api schema</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/api" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">[]</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api</code></p>
<!-- END_ae309226f6476a5c4acc7fb3419990bd -->
<!-- START_e52c0d6b4edf8947c7e3600c90531739 -->
<h2>Get filtersets</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/api/filtersets" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/filtersets</code></p>
<!-- END_e52c0d6b4edf8947c7e3600c90531739 -->
<!-- START_135eaf907d9f9f95763e73f551152091 -->
<h2>Display the specified resource.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/api/filtersets/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (500):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Server Error"
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/filtersets/{filterset}</code></p>
<!-- END_135eaf907d9f9f95763e73f551152091 -->
<!-- START_ba630c9d1416a266686c62f77db7890e -->
<h2>Remove the specified resource from storage.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://localhost:8844/api/filtersets/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>DELETE api/filtersets/{filterset}</code></p>
<!-- END_ba630c9d1416a266686c62f77db7890e -->
<!-- START_81f114bef7967dbf79e2130e3c73acaa -->
<h2>Remove the specified resources from storage.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://localhost:8844/api/filtersets" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>DELETE api/filtersets</code></p>
<!-- END_81f114bef7967dbf79e2130e3c73acaa -->
<!-- START_a925a8d22b3615f12fca79456d286859 -->
<h2>User login attempt, generates JWT token</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost:8844/api/auth/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"aut","password":"architecto"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/auth/login</code></p>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>email</code></td>
<td>string</td>
<td>required</td>
</tr>
<tr>
<td><code>password</code></td>
<td>string</td>
<td>required</td>
</tr>
</tbody>
</table>
<!-- END_a925a8d22b3615f12fca79456d286859 -->
<!-- START_16928cb8fc6adf2d9bb675d62a2095c5 -->
<h2>User logout, invalidates JWT token</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/api/auth/logout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (500):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Server Error"
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/auth/logout</code></p>
<!-- END_16928cb8fc6adf2d9bb675d62a2095c5 -->
<!-- START_2e1c96dcffcfe7e0eb58d6408f1d619e -->
<h2>Publicly registers a user.</h2>
<p>Workflow is:
Store as new user with just email
Send verify email
Verify validates user account and captures new password and name
User can then login with password</p>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost:8844/api/auth/register" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"rerum"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/auth/register</code></p>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>email</code></td>
<td>string</td>
<td>required</td>
</tr>
</tbody>
</table>
<!-- END_2e1c96dcffcfe7e0eb58d6408f1d619e -->
<!-- START_994af8f47e3039ba6d6d67c09dd9e415 -->
<h2>Refresh JWT token</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost:8844/api/auth/refresh" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/auth/refresh</code></p>
<!-- END_994af8f47e3039ba6d6d67c09dd9e415 -->
<!-- START_65b6b5b61b3513f228f76bab268ff3be -->
<h2>api/auth/roles</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/api/auth/roles" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
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
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/auth/roles</code></p>
<!-- END_65b6b5b61b3513f228f76bab268ff3be -->
<!-- START_ccf08e81e5a4ef81965e0a72d4f6dfd0 -->
<h2>Send reset password email to user</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost:8844/api/auth/send-reset-password" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"eum"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/auth/send-reset-password</code></p>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>email</code></td>
<td>string</td>
<td>required</td>
</tr>
</tbody>
</table>
<!-- END_ccf08e81e5a4ef81965e0a72d4f6dfd0 -->
<!-- START_ff5ea5d04f37d8fc0f8cf5f864772614 -->
<h2>Returns the current user logged in or not status</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/api/auth/status" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "data": {
        "id": null
    },
    "meta": []
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/auth/status</code></p>
<!-- END_ff5ea5d04f37d8fc0f8cf5f864772614 -->
<!-- START_724dff539a355a83d6047ff0b83875a7 -->
<h2>Display a listing of the resource.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/api/messages/contact-messages" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (500):</p>
</blockquote>
<pre><code class="language-json">{
    "message": "Server Error"
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/messages/contact-messages</code></p>
<!-- END_724dff539a355a83d6047ff0b83875a7 -->
<!-- START_3f7fec5dff49f4ef1cf64db6ce6f7e26 -->
<h2>Store a contact message.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X POST \
    "http://localhost:8844/api/messages/contact-messages" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"voluptatibus","name":"molestiae","subject":"omnis","message":"pariatur"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>POST api/messages/contact-messages</code></p>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>email</code></td>
<td>string</td>
<td>required</td>
</tr>
<tr>
<td><code>name</code></td>
<td>string</td>
<td>required</td>
</tr>
<tr>
<td><code>subject</code></td>
<td>string</td>
<td>required</td>
</tr>
<tr>
<td><code>message</code></td>
<td>string</td>
<td>required</td>
</tr>
</tbody>
</table>
<!-- END_3f7fec5dff49f4ef1cf64db6ce6f7e26 -->
<!-- START_178c5edf8496192ff4eb44ad3b32a427 -->
<h2>Show a contact message.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X GET \
    -G "http://localhost:8844/api/messages/contact-messages/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<blockquote>
<p>Example response (200):</p>
</blockquote>
<pre><code class="language-json">{
    "data": {
        "id": 1,
        "subject": "Eaque dolore magnam minima deserunt qui qui.",
        "message": "Sed saepe animi mollitia ea quia sit facere. Id rerum ea nihil placeat in et. Incidunt qui possimus doloribus. Consequatur nihil in dolores culpa minus.",
        "name": "Pete Windler",
        "email": "virgie30@example.net",
        "created_at": "2020-07-19T21:40:44.000000Z",
        "updated_at": "2020-07-19T21:40:44.000000Z"
    }
}</code></pre>
<h3>HTTP Request</h3>
<p><code>GET api/messages/contact-messages/{contact_message}</code></p>
<!-- END_178c5edf8496192ff4eb44ad3b32a427 -->
<!-- START_7e121161c79dd05ed2d1ac8d88791570 -->
<h2>Update a contact message.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X PUT \
    "http://localhost:8844/api/messages/contact-messages/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"explicabo","name":"sint","subject":"non","message":"quas"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>PUT api/messages/contact-messages/{contact_message}</code></p>
<p><code>PATCH api/messages/contact-messages/{contact_message}</code></p>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>email</code></td>
<td>string</td>
<td>required</td>
</tr>
<tr>
<td><code>name</code></td>
<td>string</td>
<td>required</td>
</tr>
<tr>
<td><code>subject</code></td>
<td>string</td>
<td>required</td>
</tr>
<tr>
<td><code>message</code></td>
<td>string</td>
<td>required</td>
</tr>
</tbody>
</table>
<!-- END_7e121161c79dd05ed2d1ac8d88791570 -->
<!-- START_55559957f6dcd256c20a4048d75c850a -->
<h2>Delete a contact message.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://localhost:8844/api/messages/contact-messages/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>DELETE api/messages/contact-messages/{contact_message}</code></p>
<!-- END_55559957f6dcd256c20a4048d75c850a -->
<!-- START_729ee6662e8cc5275945e42496d2552c -->
<h2>Delete contact messages.</h2>
<blockquote>
<p>Example request:</p>
</blockquote>
<pre><code class="language-bash">curl -X DELETE \
    "http://localhost:8844/api/messages/contact-messages" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":"aut"}'
</code></pre>
<pre><code class="language-javascript">const url = new URL(
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
    .then(response =&gt; response.json())
    .then(json =&gt; console.log(json));</code></pre>
<h3>HTTP Request</h3>
<p><code>DELETE api/messages/contact-messages</code></p>
<h4>Body Parameters</h4>
<table>
<thead>
<tr>
<th>Parameter</th>
<th>Type</th>
<th>Status</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>ids</code></td>
<td>string</td>
<td>required</td>
</tr>
</tbody>
</table>
<!-- END_729ee6662e8cc5275945e42496d2552c -->
      </div>
      <div class="dark-box">
                        <div class="lang-selector">
                                    <a href="#" data-language-name="bash">bash</a>
                                    <a href="#" data-language-name="javascript">javascript</a>
                              </div>
                </div>
    </div>
  </body>
</html>