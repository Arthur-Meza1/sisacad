<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Sisacad API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost:8000";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.6.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.6.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-GETapi-student-cursos--curso--notas">
                                <a href="#endpoints-GETapi-student-cursos--curso--notas">GET api/student/cursos/{curso}/notas</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-student-matricular">
                                <a href="#endpoints-POSTapi-student-matricular">POST api/student/matricular</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-student-desmatricular">
                                <a href="#endpoints-POSTapi-student-desmatricular">POST api/student/desmatricular</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-teacher-grupo--grupoId--notas">
                                <a href="#endpoints-GETapi-teacher-grupo--grupoId--notas">GET api/teacher/grupo/{grupoId}/notas</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-teacher-notas-guardar">
                                <a href="#endpoints-POSTapi-teacher-notas-guardar">POST api/teacher/notas/guardar</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-teacher-sesion--id-">
                                <a href="#endpoints-GETapi-teacher-sesion--id-">GET api/teacher/sesion/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-teacher-libreta-descargar">
                                <a href="#endpoints-GETapi-teacher-libreta-descargar">GET api/teacher/libreta/descargar</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-teacher-silabo-plantilla">
                                <a href="#endpoints-GETapi-teacher-silabo-plantilla">GET api/teacher/silabo/plantilla</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-teacher-aulas">
                                <a href="#endpoints-POSTapi-teacher-aulas">POST api/teacher/aulas</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-teacher-crear_sesion">
                                <a href="#endpoints-POSTapi-teacher-crear_sesion">POST api/teacher/crear_sesion</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-teacher-sesion--sesion--guardar">
                                <a href="#endpoints-POSTapi-teacher-sesion--sesion--guardar">POST api/teacher/sesion/{sesion}/guardar</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-teacher-sesion--sesion--borrar">
                                <a href="#endpoints-POSTapi-teacher-sesion--sesion--borrar">POST api/teacher/sesion/{sesion}/borrar</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: January 14, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost:8000</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-GETapi-student-cursos--curso--notas">GET api/student/cursos/{curso}/notas</h2>

<p>
</p>



<span id="example-requests-GETapi-student-cursos--curso--notas">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/student/cursos/architecto/notas" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "ngrok-skip-browser-warning: true"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/student/cursos/architecto/notas"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "ngrok-skip-browser-warning": "true",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-student-cursos--curso--notas">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
set-cookie: XSRF-TOKEN=eyJpdiI6IkpQa1Z5b2VNcXFsWUVTc2EwWlphZWc9PSIsInZhbHVlIjoiSE85VGdabmFzT2dpY3hVOThheXE0SXgvVUJGOFZTNlc4ZkQ3ajhNMEg4bGpsQzBRY0UrQUVJNkVpL1c1MGxPb1QrbXc0UjlmdUZVRnRmb0N5TForSDhSM0hYbFYrcDM3V2xEdUtOdGw1WFJmeWU4U0xlaEcrMk5aUG1qeWNaeC8iLCJtYWMiOiI0ZWVhMWFjMTU3MDU2ZmQ3NmRjNTEzNjA0OWEwM2NiM2YyYWY1ZjI3ZmQ1ZTkxZmNhYjQ4MjRlYjlkNDlkNTRjIiwidGFnIjoiIn0%3D; expires=Wed, 14 Jan 2026 18:26:23 GMT; Max-Age=7200; path=/; samesite=lax; sisacad-session=eyJpdiI6IkxIdktsbGZ3emZxNWNZZU9Mb0NPUXc9PSIsInZhbHVlIjoibG5nRCtaYkJqUkg4eDh5NGUrNUdERWZQRUgxZ2dkSmRBekFSbEhEa1NZWmlWL28veEJaSUE2VnJYSThCS1pJditEM0s1YzEwODhxRHMyQnFCTFlYMzF0VU1vVHJ0V3JZc1JVdFRyMFVkQ1k4OURMc1lyVWRodUlENm1nN2Y1TEYiLCJtYWMiOiI5ZGU2YzQwYjMzM2VlMTVhMjdmMDZmYTM1OWVhYmY5ZTEzNmIxMjVjZDFjMGNhOGVmMTEwMmRlOGM2ZDg2NGFiIiwidGFnIjoiIn0%3D; expires=Wed, 14 Jan 2026 18:26:23 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Server Error&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-student-cursos--curso--notas" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-student-cursos--curso--notas"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-student-cursos--curso--notas"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-student-cursos--curso--notas" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-student-cursos--curso--notas">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-student-cursos--curso--notas" data-method="GET"
      data-path="api/student/cursos/{curso}/notas"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-student-cursos--curso--notas', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-student-cursos--curso--notas"
                    onclick="tryItOut('GETapi-student-cursos--curso--notas');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-student-cursos--curso--notas"
                    onclick="cancelTryOut('GETapi-student-cursos--curso--notas');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-student-cursos--curso--notas"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/student/cursos/{curso}/notas</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-student-cursos--curso--notas"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-student-cursos--curso--notas"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ngrok-skip-browser-warning</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ngrok-skip-browser-warning"                data-endpoint="GETapi-student-cursos--curso--notas"
               value="true"
               data-component="header">
    <br>
<p>Example: <code>true</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>curso</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="curso"                data-endpoint="GETapi-student-cursos--curso--notas"
               value="architecto"
               data-component="url">
    <br>
<p>The curso. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-student-matricular">POST api/student/matricular</h2>

<p>
</p>



<span id="example-requests-POSTapi-student-matricular">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/student/matricular" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "ngrok-skip-browser-warning: true"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/student/matricular"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "ngrok-skip-browser-warning": "true",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-student-matricular">
</span>
<span id="execution-results-POSTapi-student-matricular" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-student-matricular"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-student-matricular"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-student-matricular" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-student-matricular">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-student-matricular" data-method="POST"
      data-path="api/student/matricular"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-student-matricular', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-student-matricular"
                    onclick="tryItOut('POSTapi-student-matricular');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-student-matricular"
                    onclick="cancelTryOut('POSTapi-student-matricular');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-student-matricular"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/student/matricular</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-student-matricular"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-student-matricular"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ngrok-skip-browser-warning</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ngrok-skip-browser-warning"                data-endpoint="POSTapi-student-matricular"
               value="true"
               data-component="header">
    <br>
<p>Example: <code>true</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-student-desmatricular">POST api/student/desmatricular</h2>

<p>
</p>



<span id="example-requests-POSTapi-student-desmatricular">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/student/desmatricular" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "ngrok-skip-browser-warning: true"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/student/desmatricular"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "ngrok-skip-browser-warning": "true",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-student-desmatricular">
</span>
<span id="execution-results-POSTapi-student-desmatricular" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-student-desmatricular"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-student-desmatricular"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-student-desmatricular" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-student-desmatricular">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-student-desmatricular" data-method="POST"
      data-path="api/student/desmatricular"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-student-desmatricular', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-student-desmatricular"
                    onclick="tryItOut('POSTapi-student-desmatricular');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-student-desmatricular"
                    onclick="cancelTryOut('POSTapi-student-desmatricular');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-student-desmatricular"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/student/desmatricular</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-student-desmatricular"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-student-desmatricular"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ngrok-skip-browser-warning</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ngrok-skip-browser-warning"                data-endpoint="POSTapi-student-desmatricular"
               value="true"
               data-component="header">
    <br>
<p>Example: <code>true</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-teacher-grupo--grupoId--notas">GET api/teacher/grupo/{grupoId}/notas</h2>

<p>
</p>



<span id="example-requests-GETapi-teacher-grupo--grupoId--notas">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/teacher/grupo/architecto/notas" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "ngrok-skip-browser-warning: true"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/teacher/grupo/architecto/notas"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "ngrok-skip-browser-warning": "true",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-teacher-grupo--grupoId--notas">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
set-cookie: XSRF-TOKEN=eyJpdiI6IjlZZjFIekgwR0J5SFlBNFRNdVlFRWc9PSIsInZhbHVlIjoiM3FianZsK1lmbGY4ai8zODFhUWpiVzZ0VllIUUkvM3ZlSzNtMFMybDBQdy9uNFUxa3hsY25jNmFXb1NLZFBYamdUYjZWeGdLQ2NHTDlaQ2hUQ0x5dVJ2bGU5dHJselQ2RG1PbkVwTWNXdXNsY2czR3NOcWlIUXZNZEVQRUx2cE0iLCJtYWMiOiIxNWQwZTRmMjhlMDk1NmY2YWMxZjY5MzdmYjA5ZjJlOGY5NzNhZWJlODE2MDVlMTAzNjU1ZDk2MjMxYzc0OWI4IiwidGFnIjoiIn0%3D; expires=Wed, 14 Jan 2026 18:26:23 GMT; Max-Age=7200; path=/; samesite=lax; sisacad-session=eyJpdiI6IlV5bUpNb0dVWGRPNHFBeldvcy92QkE9PSIsInZhbHVlIjoiY28yZjkvNU10YW5icm9rSHFud2RkNHBYaERVNVpINFhRTjVYaXhzZm0wUGRrcWxyc3liZHBabERDbU4vOGo0ejBOaGlSdU11NlJPbUgzSXBPdEk2bnpUdy96Smx2cVJKOUNPZXdoQmFrMVNucHZtM3FBdlBoZEt1THF1UGRHUEMiLCJtYWMiOiIyMzViNTY2ZGJiNDVkY2QwZGZiYTI2YzdiNmFlMGVkMjYzNGUyYzU3ZDYzZjkzM2U1MmZiOTNiMTc4MjkzOGY5IiwidGFnIjoiIn0%3D; expires=Wed, 14 Jan 2026 18:26:23 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Server Error&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-teacher-grupo--grupoId--notas" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-teacher-grupo--grupoId--notas"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-teacher-grupo--grupoId--notas"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-teacher-grupo--grupoId--notas" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-teacher-grupo--grupoId--notas">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-teacher-grupo--grupoId--notas" data-method="GET"
      data-path="api/teacher/grupo/{grupoId}/notas"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-teacher-grupo--grupoId--notas', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-teacher-grupo--grupoId--notas"
                    onclick="tryItOut('GETapi-teacher-grupo--grupoId--notas');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-teacher-grupo--grupoId--notas"
                    onclick="cancelTryOut('GETapi-teacher-grupo--grupoId--notas');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-teacher-grupo--grupoId--notas"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/teacher/grupo/{grupoId}/notas</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-teacher-grupo--grupoId--notas"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-teacher-grupo--grupoId--notas"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ngrok-skip-browser-warning</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ngrok-skip-browser-warning"                data-endpoint="GETapi-teacher-grupo--grupoId--notas"
               value="true"
               data-component="header">
    <br>
<p>Example: <code>true</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>grupoId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="grupoId"                data-endpoint="GETapi-teacher-grupo--grupoId--notas"
               value="architecto"
               data-component="url">
    <br>
<p>Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-teacher-notas-guardar">POST api/teacher/notas/guardar</h2>

<p>
</p>



<span id="example-requests-POSTapi-teacher-notas-guardar">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/teacher/notas/guardar" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "ngrok-skip-browser-warning: true" \
    --data "{
    \"data\": [
        {
            \"registro_id\": 16,
            \"notas\": [
                4326.41688
            ]
        }
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/teacher/notas/guardar"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "ngrok-skip-browser-warning": "true",
};

let body = {
    "data": [
        {
            "registro_id": 16,
            "notas": [
                4326.41688
            ]
        }
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-teacher-notas-guardar">
</span>
<span id="execution-results-POSTapi-teacher-notas-guardar" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-teacher-notas-guardar"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-teacher-notas-guardar"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-teacher-notas-guardar" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-teacher-notas-guardar">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-teacher-notas-guardar" data-method="POST"
      data-path="api/teacher/notas/guardar"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-teacher-notas-guardar', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-teacher-notas-guardar"
                    onclick="tryItOut('POSTapi-teacher-notas-guardar');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-teacher-notas-guardar"
                    onclick="cancelTryOut('POSTapi-teacher-notas-guardar');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-teacher-notas-guardar"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/teacher/notas/guardar</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-teacher-notas-guardar"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-teacher-notas-guardar"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ngrok-skip-browser-warning</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ngrok-skip-browser-warning"                data-endpoint="POSTapi-teacher-notas-guardar"
               value="true"
               data-component="header">
    <br>
<p>Example: <code>true</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>data</code></b>&nbsp;&nbsp;
<small>object[]</small>&nbsp;
 &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>registro_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="data.0.registro_id"                data-endpoint="POSTapi-teacher-notas-guardar"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>notas</code></b>&nbsp;&nbsp;
<small>number[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="data.0.notas[0]"                data-endpoint="POSTapi-teacher-notas-guardar"
               data-component="body">
        <input type="number" style="display: none"
               name="data.0.notas[1]"                data-endpoint="POSTapi-teacher-notas-guardar"
               data-component="body">
    <br>

                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-teacher-sesion--id-">GET api/teacher/sesion/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-teacher-sesion--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/teacher/sesion/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "ngrok-skip-browser-warning: true"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/teacher/sesion/architecto"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "ngrok-skip-browser-warning": "true",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-teacher-sesion--id-">
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
set-cookie: XSRF-TOKEN=eyJpdiI6IkVrZmRuZ1pLcFVnT1ZPTUl2V0JvUnc9PSIsInZhbHVlIjoiUVRTczk5dzZqcUJ5Z1Q4M3R2QlV3cVhHaURXNHJQc1dubnE3SWlmYiswUURxK29TQnRMZWFrRmFZREdvMm1ESHJqakpUSUpIM0syVFY5SXQxL29JK1dnMmN3c0p1WCtpVnJzTVBZeVpqNkJHQ3lpaitHY0dkRUcyVzJ0Q3ovVzIiLCJtYWMiOiIwMWZmZjVjNzIzY2VlNTM1ZDkwNzkyZTMyMGE4MTM1MTc3ODBjNWFjNWQ2MWMwZjJkODZkYmFiNDhiYmZiYjgyIiwidGFnIjoiIn0%3D; expires=Wed, 14 Jan 2026 18:26:23 GMT; Max-Age=7200; path=/; samesite=lax; sisacad-session=eyJpdiI6IjBWZnBiUkQwVGFTYVFHREk4RU1meFE9PSIsInZhbHVlIjoiUVZHQ3FRK1J1VHNqOGpiOE9XVVdnbG5QaGFrVTZNRUtaak44R00zaEduakUvWHVxbkpLRnpjc3RKQlFQbGVmdVBpMFZNTS9xQWhtSHBISkZMa0xmcFNjRUFyY2EveHRSb3dsWVBWZFA5YlNCK0RIVGZFNDRoSFEwNGd1d0hZZFEiLCJtYWMiOiIwNDNhZDExYjE0MTI5MDA3YTJhMDYxODgyZjcxMTE1NjA2NzllYjRmYzY4MzJlYTUwN2NjYzEzYzZmZTljNzgxIiwidGFnIjoiIn0%3D; expires=Wed, 14 Jan 2026 18:26:23 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Server Error&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-teacher-sesion--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-teacher-sesion--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-teacher-sesion--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-teacher-sesion--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-teacher-sesion--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-teacher-sesion--id-" data-method="GET"
      data-path="api/teacher/sesion/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-teacher-sesion--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-teacher-sesion--id-"
                    onclick="tryItOut('GETapi-teacher-sesion--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-teacher-sesion--id-"
                    onclick="cancelTryOut('GETapi-teacher-sesion--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-teacher-sesion--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/teacher/sesion/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-teacher-sesion--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-teacher-sesion--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ngrok-skip-browser-warning</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ngrok-skip-browser-warning"                data-endpoint="GETapi-teacher-sesion--id-"
               value="true"
               data-component="header">
    <br>
<p>Example: <code>true</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-teacher-sesion--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the sesion. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-teacher-libreta-descargar">GET api/teacher/libreta/descargar</h2>

<p>
</p>



<span id="example-requests-GETapi-teacher-libreta-descargar">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/teacher/libreta/descargar" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "ngrok-skip-browser-warning: true"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/teacher/libreta/descargar"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "ngrok-skip-browser-warning": "true",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-teacher-libreta-descargar">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: public
content-disposition: attachment; filename=libreta.xlsx
content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
accept-ranges: bytes
access-control-allow-origin: *
set-cookie: XSRF-TOKEN=eyJpdiI6InhLaHdPNnJzamRzUm9IUmt4MTJoOEE9PSIsInZhbHVlIjoiR0U2dlAxNjA1Smcwa3NQcDU4YXhpQkRUdUtBL2lKSkVBOVdDeThtcFZFRW9Ed0dCdnllU1ZOTUVlYllBcGRscmxlWllmRCtGb095NTVwR1NiRUVDbE1pUk50VHVZRDFKempOTVVFM3VETFhjVHpLSlU1UnpzYTJRMnJ4OVl3VTAiLCJtYWMiOiIxOGZiZDk0NzJmNzExMzYxNDUxMDk3Y2Y3Zjc1NDg1NDBlMTA3Nzk4OTZkZjFhZWMwZGE2YWExYTdhNjZjNWNkIiwidGFnIjoiIn0%3D; expires=Wed, 14 Jan 2026 18:26:23 GMT; Max-Age=7200; path=/; samesite=lax; sisacad-session=eyJpdiI6IlUzc3BzOXdWYTdLODgyRXFQTHNkeWc9PSIsInZhbHVlIjoiZXkvZjNEemE5bGJUdHBuZUZkWTcwd2htYlVBVTE4ZHVUa3RmTFBYbjZrQ0tkblUrQ0hXYjg5YmZFRWpuYld5Y3RQTU9zMHI1enJpN05qbDhGOXphZDczY0dQd3FMNlRRT2xRdmhUWW00dmhUcGJ4cHpuTHIyZ01ISTRmcitISzkiLCJtYWMiOiI3N2NjZWFhMjAxZGI2ZjI1ODJmNTU5OWUyNTUzN2NmNzA5MzMwZjA3ZGFlMzQyNWM1ODBiMTI3MzU3NTQwY2QwIiwidGFnIjoiIn0%3D; expires=Wed, 14 Jan 2026 18:26:23 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;"></code>
 </pre>
    </span>
<span id="execution-results-GETapi-teacher-libreta-descargar" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-teacher-libreta-descargar"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-teacher-libreta-descargar"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-teacher-libreta-descargar" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-teacher-libreta-descargar">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-teacher-libreta-descargar" data-method="GET"
      data-path="api/teacher/libreta/descargar"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-teacher-libreta-descargar', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-teacher-libreta-descargar"
                    onclick="tryItOut('GETapi-teacher-libreta-descargar');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-teacher-libreta-descargar"
                    onclick="cancelTryOut('GETapi-teacher-libreta-descargar');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-teacher-libreta-descargar"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/teacher/libreta/descargar</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-teacher-libreta-descargar"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-teacher-libreta-descargar"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ngrok-skip-browser-warning</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ngrok-skip-browser-warning"                data-endpoint="GETapi-teacher-libreta-descargar"
               value="true"
               data-component="header">
    <br>
<p>Example: <code>true</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-teacher-silabo-plantilla">GET api/teacher/silabo/plantilla</h2>

<p>
</p>



<span id="example-requests-GETapi-teacher-silabo-plantilla">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/teacher/silabo/plantilla" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "ngrok-skip-browser-warning: true"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/teacher/silabo/plantilla"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "ngrok-skip-browser-warning": "true",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-teacher-silabo-plantilla">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: public
content-disposition: attachment; filename=silabo-plantilla.pdf
content-type: application/pdf
accept-ranges: bytes
access-control-allow-origin: *
set-cookie: XSRF-TOKEN=eyJpdiI6InM5UXhPWFNVTCt4ZFR3Zm1zTmFzYUE9PSIsInZhbHVlIjoiZGo4bld3SzcvRzhFM1ZjQXU1TWs1amxLWjFvN3lDREpwMG9ST1JVOHBjY0JDUUVLOWVQS05iSlRiTHRBOFd0eWhqSkhESjJkM2J6L3d2cDFSanZNd3RleTRCS2NXb0NXMzh4dE1WbFJuSzBFZGFjR2Y3bWpkTXpRdXdKVUhZU2MiLCJtYWMiOiI3YzI5MTVlNDgzOGFhY2JhYzFjY2FlNmNiMjk1OTVhYjAxM2E2ZGI2ZTIxNjI1NjUyMGRlYThkZTU2YWY1NmZhIiwidGFnIjoiIn0%3D; expires=Wed, 14 Jan 2026 18:26:23 GMT; Max-Age=7200; path=/; samesite=lax; sisacad-session=eyJpdiI6ImNod1N0NmNicGVTejlXQzlWY0tQS3c9PSIsInZhbHVlIjoicmxWV1N1T2VmVFQ1d2svQ051dzQzbDMyZmZUM0Z5TDVoSXVxL1ZhTStwY0Zha2VsaEI3b3dCaU9EcXVaeldqWnVkQ293MktYZGNlNWNZWUxiT3lKVkZiblR1RzRocUU3MjhIcURpVmpQRGU4VE9aQVRMZGhRdnJHbE1OUkJNV1kiLCJtYWMiOiJjODA0YWU1NWE0YmJhZTFjODFkODMwNTk1OGEwMjczMmI0YjU4NWQwMzQxZWY2ZTVkYWI0NWEzZTdmZGZiMDJmIiwidGFnIjoiIn0%3D; expires=Wed, 14 Jan 2026 18:26:23 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;"></code>
 </pre>
    </span>
<span id="execution-results-GETapi-teacher-silabo-plantilla" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-teacher-silabo-plantilla"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-teacher-silabo-plantilla"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-teacher-silabo-plantilla" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-teacher-silabo-plantilla">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-teacher-silabo-plantilla" data-method="GET"
      data-path="api/teacher/silabo/plantilla"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-teacher-silabo-plantilla', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-teacher-silabo-plantilla"
                    onclick="tryItOut('GETapi-teacher-silabo-plantilla');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-teacher-silabo-plantilla"
                    onclick="cancelTryOut('GETapi-teacher-silabo-plantilla');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-teacher-silabo-plantilla"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/teacher/silabo/plantilla</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-teacher-silabo-plantilla"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-teacher-silabo-plantilla"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ngrok-skip-browser-warning</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ngrok-skip-browser-warning"                data-endpoint="GETapi-teacher-silabo-plantilla"
               value="true"
               data-component="header">
    <br>
<p>Example: <code>true</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-teacher-aulas">POST api/teacher/aulas</h2>

<p>
</p>



<span id="example-requests-POSTapi-teacher-aulas">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/teacher/aulas" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "ngrok-skip-browser-warning: true" \
    --data "{
    \"fecha\": \"architecto\",
    \"hora_inicio\": \"architecto\",
    \"hora_fin\": \"architecto\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/teacher/aulas"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "ngrok-skip-browser-warning": "true",
};

let body = {
    "fecha": "architecto",
    "hora_inicio": "architecto",
    "hora_fin": "architecto"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-teacher-aulas">
</span>
<span id="execution-results-POSTapi-teacher-aulas" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-teacher-aulas"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-teacher-aulas"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-teacher-aulas" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-teacher-aulas">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-teacher-aulas" data-method="POST"
      data-path="api/teacher/aulas"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-teacher-aulas', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-teacher-aulas"
                    onclick="tryItOut('POSTapi-teacher-aulas');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-teacher-aulas"
                    onclick="cancelTryOut('POSTapi-teacher-aulas');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-teacher-aulas"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/teacher/aulas</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-teacher-aulas"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-teacher-aulas"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ngrok-skip-browser-warning</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ngrok-skip-browser-warning"                data-endpoint="POSTapi-teacher-aulas"
               value="true"
               data-component="header">
    <br>
<p>Example: <code>true</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>fecha</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="fecha"                data-endpoint="POSTapi-teacher-aulas"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>hora_inicio</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="hora_inicio"                data-endpoint="POSTapi-teacher-aulas"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>hora_fin</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="hora_fin"                data-endpoint="POSTapi-teacher-aulas"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-teacher-crear_sesion">POST api/teacher/crear_sesion</h2>

<p>
</p>



<span id="example-requests-POSTapi-teacher-crear_sesion">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/teacher/crear_sesion" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "ngrok-skip-browser-warning: true" \
    --data "{
    \"grupo_id\": \"architecto\",
    \"fecha\": \"architecto\",
    \"hora_inicio\": \"architecto\",
    \"hora_fin\": \"architecto\",
    \"aula_id\": \"architecto\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/teacher/crear_sesion"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "ngrok-skip-browser-warning": "true",
};

let body = {
    "grupo_id": "architecto",
    "fecha": "architecto",
    "hora_inicio": "architecto",
    "hora_fin": "architecto",
    "aula_id": "architecto"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-teacher-crear_sesion">
</span>
<span id="execution-results-POSTapi-teacher-crear_sesion" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-teacher-crear_sesion"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-teacher-crear_sesion"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-teacher-crear_sesion" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-teacher-crear_sesion">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-teacher-crear_sesion" data-method="POST"
      data-path="api/teacher/crear_sesion"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-teacher-crear_sesion', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-teacher-crear_sesion"
                    onclick="tryItOut('POSTapi-teacher-crear_sesion');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-teacher-crear_sesion"
                    onclick="cancelTryOut('POSTapi-teacher-crear_sesion');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-teacher-crear_sesion"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/teacher/crear_sesion</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-teacher-crear_sesion"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-teacher-crear_sesion"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ngrok-skip-browser-warning</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ngrok-skip-browser-warning"                data-endpoint="POSTapi-teacher-crear_sesion"
               value="true"
               data-component="header">
    <br>
<p>Example: <code>true</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>grupo_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="grupo_id"                data-endpoint="POSTapi-teacher-crear_sesion"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>fecha</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="fecha"                data-endpoint="POSTapi-teacher-crear_sesion"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>hora_inicio</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="hora_inicio"                data-endpoint="POSTapi-teacher-crear_sesion"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>hora_fin</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="hora_fin"                data-endpoint="POSTapi-teacher-crear_sesion"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>aula_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="aula_id"                data-endpoint="POSTapi-teacher-crear_sesion"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-teacher-sesion--sesion--guardar">POST api/teacher/sesion/{sesion}/guardar</h2>

<p>
</p>



<span id="example-requests-POSTapi-teacher-sesion--sesion--guardar">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/teacher/sesion/architecto/guardar" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "ngrok-skip-browser-warning: true" \
    --data "{
    \"alumnos\": [
        \"1\"
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/teacher/sesion/architecto/guardar"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "ngrok-skip-browser-warning": "true",
};

let body = {
    "alumnos": [
        "1"
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-teacher-sesion--sesion--guardar">
</span>
<span id="execution-results-POSTapi-teacher-sesion--sesion--guardar" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-teacher-sesion--sesion--guardar"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-teacher-sesion--sesion--guardar"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-teacher-sesion--sesion--guardar" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-teacher-sesion--sesion--guardar">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-teacher-sesion--sesion--guardar" data-method="POST"
      data-path="api/teacher/sesion/{sesion}/guardar"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-teacher-sesion--sesion--guardar', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-teacher-sesion--sesion--guardar"
                    onclick="tryItOut('POSTapi-teacher-sesion--sesion--guardar');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-teacher-sesion--sesion--guardar"
                    onclick="cancelTryOut('POSTapi-teacher-sesion--sesion--guardar');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-teacher-sesion--sesion--guardar"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/teacher/sesion/{sesion}/guardar</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-teacher-sesion--sesion--guardar"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-teacher-sesion--sesion--guardar"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ngrok-skip-browser-warning</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ngrok-skip-browser-warning"                data-endpoint="POSTapi-teacher-sesion--sesion--guardar"
               value="true"
               data-component="header">
    <br>
<p>Example: <code>true</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sesion</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sesion"                data-endpoint="POSTapi-teacher-sesion--sesion--guardar"
               value="architecto"
               data-component="url">
    <br>
<p>The sesion. Example: <code>architecto</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>alumnos</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="alumnos[0]"                data-endpoint="POSTapi-teacher-sesion--sesion--guardar"
               data-component="body">
        <input type="text" style="display: none"
               name="alumnos[1]"                data-endpoint="POSTapi-teacher-sesion--sesion--guardar"
               data-component="body">
    <br>

Must be one of:
<ul style="list-style-type: square;"><li><code>0</code></li> <li><code>1</code></li></ul>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-teacher-sesion--sesion--borrar">POST api/teacher/sesion/{sesion}/borrar</h2>

<p>
</p>



<span id="example-requests-POSTapi-teacher-sesion--sesion--borrar">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/teacher/sesion/architecto/borrar" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "ngrok-skip-browser-warning: true"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/teacher/sesion/architecto/borrar"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "ngrok-skip-browser-warning": "true",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-teacher-sesion--sesion--borrar">
</span>
<span id="execution-results-POSTapi-teacher-sesion--sesion--borrar" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-teacher-sesion--sesion--borrar"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-teacher-sesion--sesion--borrar"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-teacher-sesion--sesion--borrar" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-teacher-sesion--sesion--borrar">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-teacher-sesion--sesion--borrar" data-method="POST"
      data-path="api/teacher/sesion/{sesion}/borrar"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-teacher-sesion--sesion--borrar', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-teacher-sesion--sesion--borrar"
                    onclick="tryItOut('POSTapi-teacher-sesion--sesion--borrar');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-teacher-sesion--sesion--borrar"
                    onclick="cancelTryOut('POSTapi-teacher-sesion--sesion--borrar');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-teacher-sesion--sesion--borrar"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/teacher/sesion/{sesion}/borrar</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-teacher-sesion--sesion--borrar"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-teacher-sesion--sesion--borrar"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ngrok-skip-browser-warning</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ngrok-skip-browser-warning"                data-endpoint="POSTapi-teacher-sesion--sesion--borrar"
               value="true"
               data-component="header">
    <br>
<p>Example: <code>true</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sesion</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sesion"                data-endpoint="POSTapi-teacher-sesion--sesion--borrar"
               value="architecto"
               data-component="url">
    <br>
<p>The sesion. Example: <code>architecto</code></p>
            </div>
                    </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
