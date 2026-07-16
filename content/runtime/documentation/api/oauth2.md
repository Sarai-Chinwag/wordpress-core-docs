---
type: document
title: OAuth2 authentication
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/oauth2/"
tags:
timestamp: "2026-06-16T19:29:26+00:00"
wordpress:
  id: 2487
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:26"
  date_gmt: "2026-06-16 19:29:26"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: oauth2
  parent: 2499
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/oauth2/"
  comment_count: 0
---

[OAuth2](https://oauth.net/2/) lets applications securely access WordPress.com and Jetpack sites without needing users’ passwords. It provides fine-grained control over what each app can access.

OAuth2 lets apps request only the specific permissions they need through “scopes”. When users authorize an app, they can see and control exactly what access they’re granting.

Users sign in with their WordPress.com account and can approve or deny the requested permissions, maintaining control over their data while safely connecting apps.

Looking for code examples? Check out the [WordPress.com REST API Examples repository](https://github.com/Automattic/wpcom-rest-api-examples), which contains sample projects demonstrating OAuth authentication and API usage in various programming languages and frameworks. The repository includes examples of both OAuth-based authentication for user-authorized operations and Application Password authentication for direct API endpoint access.

## Prerequisites

Before developing your OAuth2 application, you need to have a WordPress.com application registered with the following data:

1. **Client ID**: Identifies your application
2. **Client Secret**: Authenticates your application (keep secure)
3. **Redirect URI**: Where users return after authorization

You can obtain these credentials through the [WordPress.com Applications Manager](https://developer.wordpress.com/apps/).

Use [this form](https://developer.wordpress.com/apps/new/) to register a new WordPress.com Application

## OAuth2 endpoints

If you’re new to OAuth2, you can learn more at <https://oauth.net/>. For WordPress.com integration, you need to understand the core OAuth2 endpoints available under the `https://public-api.wordpress.com/oauth2/` namespace. These endpoints work consistently for both WordPress.com sites and Jetpack-connected sites.

### Authorization Endpoint

**Endpoint**: `https://public-api.wordpress.com/oauth2/authorize`

**Method**: GET (via user redirect)

This is where the OAuth2 flow begins. Users are presented with an authorization interface to review and approve the permissions your application is requesting. The endpoint validates your application credentials, redirect URI, and generates secure authorization codes for token exchange.

**Required Parameters**:

- `client_id`: Your application’s client ID
- `redirect_uri`: Must match registered redirect URI
- `response_type`: “code” for [Authorization Code Flow](#Authorization-Code-Flow) or “token” for [Implicit Flow](#Implicit-Flow)

**Optional Parameters**:

- `scope`: Space-separated permissions (defaults to single-blog access)
- `state`: Recommended for CSRF protection
- `blog`: Specific blog URL or ID for single-site access

**Example Authorization URL** (Authorization Code Flow):

`https://public-api.wordpress.com/oauth2/authorize?client_id=12345&redirect_uri=https%3A%2F%2Fyourapp.com%2Fcallback&<mark class="has-inline-color" style="background-color:#e7e8e8">response_type=code</mark>&scope=posts%20media&state=abc123xyz`

**Example Authorization URL** (Implicit Flow):

`https://public-api.wordpress.com/oauth2/authorize?client_id=12345&redirect_uri=https%3A%2F%2Fyourapp.com%2Fcallback&<mark class="has-inline-color" style="background-color:#e7e8e8">response_type=token</mark>&scope=posts%20media&state=abc123xyz`

**Example Authorization URL** (Specific Blog):

`https://public-api.wordpress.com/oauth2/authorize?client_id=12345&redirect_uri=https%3A%2F%2Fyourapp.com%2Fcallback&response_type=code&<mark class="has-inline-color" style="background-color:#e7e8e8">blog=yourblog.wordpress.com</mark>&scope=posts%20media&state=abc123xyz`

**Response/Action**: After user approval, redirects to your redirect\_uri with:

- **Authorization Code Flow**: `?code=AUTHORIZATION_CODE&state=YOUR_STATE`
- **Implicit Flow**: `#access_token=TOKEN&expires_in=64800&token_type=bearer&site_id=BLOG_ID`
- **User denial**: `?error=access_denied`

**Important Note**: The redirect\_uri parameter must exactly match the redirect URI registered when creating your application. Even minor differences (like missing trailing slashes) will cause the authorization to fail. This is a security measure to prevent malicious redirects.

### Token Request Endpoint

**Endpoint**: `https://public-api.wordpress.com/oauth2/token`

**Method**: POST

This secure server-to-server endpoint handles two different grant types for obtaining access tokens. Choose the appropriate grant type based on your use case:

#### Authorization Code Grant (Production Use)

Use this grant type for all production applications. It exchanges authorization codes (received from user authorization) for access tokens while keeping your client secret secure.

**Required Parameters**:

- `client_id`: Your application’s client ID
- `client_secret`: Your application’s client secret
- `code`: Authorization code from the [authorization step](#Authorization-Endpoint)
- `grant_type`: Must be “authorization\_code”
- `redirect_uri`: Must match the authorization redirect URI

**Example Request**:

```
curl -X POST https://public-api.wordpress.com/oauth2/token 
  -d "client_id=12345" 
  -d "client_secret=your_client_secret" 
  -d "code=received_authorization_code" 
  -d "grant_type=authorization_code" 
  -d "redirect_uri=https://yourapp.com/callback"
```

curl -X POST https://public-api.wordpress.com/oauth2/token -d "client\_id=12345" -d "client\_secret=your\_client\_secret" -d "code=received\_authorization\_code" -d "grant\_type=authorization\_code" -d "redirect\_uri=https://yourapp.com/callback"CopyCopied

#### Password Grant (Development &amp; Testing Only)

This grant type allows application owners to obtain tokens directly using their WordPress.com credentials, bypassing the [user authorization flow](#Authorization-Endpoint).

**Use Password Grant For**:

- Testing API endpoints during development
- Automated testing where user authorization simulation is impractical
- Personal development on your own WordPress.com sites

**Security Restrictions**:

- Only works with **your own** WordPress.com credentials (not other users’)
- Requires exposing credentials in your code
- Bypasses OAuth2’s user consent and security benefits
- **Never use in production applications**

**Required Parameters**:

- `client_id`: Your application’s client ID
- `client_secret`: Your application’s client secret
- `grant_type`: Must be “password”
- `username`: Your WordPress.com username
- `password`: Your WordPress.com password (or [Application Password](https://wordpress.com/support/security/two-step-authentication/application-specific-passwords/) if 2FA enabled)

**Example Request**:

```
curl -X POST https://public-api.wordpress.com/oauth2/token 
  -d "client_id=12345" 
  -d "client_secret=your_client_secret" 
  -d "grant_type=password" 
  -d "username=your_username" 
  -d "password=your_password_or_app_password"
```

curl -X POST https://public-api.wordpress.com/oauth2/token -d "client\_id=12345" -d "client\_secret=your\_client\_secret" -d "grant\_type=password" -d "username=your\_username" -d "password=your\_password\_or\_app\_password"CopyCopied

**Two-Factor Authentication**: If you have 2FA enabled, create an Application Password in your [WordPress.com Account Settings](https://wordpress.com/me/security) and use that instead of your regular password.

**Migration Path**: Start with Password Grant for development convenience, but implement Authorization Code Flow before launching to production. Think of Password Grant as a development shortcut that must be replaced with proper user authorization in live applications.

**Token Response Format** (Both Grant Types):

```
{
    "access_token": "YOUR_API_TOKEN",
    "blog_id": "blog_id_number", 
    "blog_url": "https://yourblog.wordpress.com",
    "token_type": "bearer"
}
```

{ "access\_token": "YOUR\_API\_TOKEN", "blog\_id": "blog\_id\_number", "blog\_url": "https://yourblog.wordpress.com", "token\_type": "bearer" }CopyCopied

### Token Information Endpoint

**Endpoint**: `https://public-api.wordpress.com/oauth2/token-info`

**Method**: GET

Provides secure token validation and inspection. Returns detailed information about tokens, including user ID, blog ID, and scope permissions. Essential for verifying token authenticity, especially when tokens are transmitted between systems or in mobile applications.

**Required Parameters**:

- `client_id`: Your application’s client ID
- `token`: The access token to validate

**Example Request**:

`GET https://public-api.wordpress.com/oauth2/token-info?client_id=12345&token=your_access_token_here`

**Example CURL Request**:

`curl "https://public-api.wordpress.com/oauth2/token-info?client_id=12345&token=your_access_token_here"`

**Response Format** (Valid Token):

```
{
    "client_id": "12345",
    "user_id": "123456789",
    "blog_id": "987654321", 
    "scope": "posts,media"
}
```

{ "client\_id": "12345", "user\_id": "123456789", "blog\_id": "987654321", "scope": "posts,media" }CopyCopied

**Response** (Invalid Token): Returns an error if the token was not authorized for your application or is invalid.

### Authentication Endpoint

**Endpoint**: `https://public-api.wordpress.com/oauth2/authenticate`

**Method**: GET (via user redirect)

A specialized endpoint for WordPress.com Connect applications that only need basic user identity verification. Optimized for “Login with WordPress.com” functionality, designed for identity verification rather than content management.

**Required Parameters**:

- `client_id`: Your application’s client ID
- `redirect_uri`: Must match registered redirect URI
- `response_type`: Use “code” for secure server-side exchange

**Optional Parameters**:

- `scope`: Typically “auth” for basic profile access
- `state`: Recommended for CSRF protection

**Example Authentication URL**:

`https://public-api.wordpress.com/oauth2/authenticate?client_id=12345&redirect_uri=https%3A%2F%2Fyourapp.com%2Fauth-callback&response_type=code&scope=auth&state=random_secure_string`

**Response/Action**: After user approval, redirects to your redirect\_uri with an authorization code. Exchange this code at the token endpoint to receive a token with limited scope, typically providing access only to:

**Available API Access**:

- `/me/` endpoint for basic user profile information
- User identity verification data (ID, username, email, avatar\_URL, verified status)

## OAuth2 Workflows

WordPress.com supports two main OAuth2 workflows, each designed for different application types and security requirements:

### Authorization Code Flow (Recommended)

The Authorization Code Flow is the standard OAuth2 workflow for **server-side applications** where you can securely store client secrets. This flow provides the highest security by exchanging an authorization code for an access token through a secure server-to-server request.

**Security advantage**: The client secret never appears in client-side code, and access tokens are obtained through authenticated server requests.

[![Flowchart illustrating the OAuth2 authorization code flow, detailing steps for user login, authorization page display, permission approval, and access token retrieval across user, application, and WordPress.com authorization server.](https://developer.wordpress.com/wp-content/uploads/2024/02/image-4.png?w=1024)](https://developer.wordpress.com/wp-content/uploads/2024/02/image-4.png)### Implicit Flow (Legacy)

The Implicit Flow was designed for **browser-based applications** where the access token is returned directly in the URL fragment. However, this approach is now considered less secure and has been largely deprecated in favor of more secure alternatives like PKCE (Proof Key for Code Exchange).

**Important**: We recommend using the Authorization Code Flow whenever possible for enhanced security.

[![Flowchart illustrating the OAuth2 Implicit Flow (Legacy) process, showing steps for user authorization, including initiating login requests, displaying authorization pages, and redirecting with authorization codes.](https://developer.wordpress.com/wp-content/uploads/2024/02/image-6.png?w=1024)](https://developer.wordpress.com/wp-content/uploads/2024/02/image-6.png)## OAuth2 Scopes and Permissions

OAuth2’s power lies in its granular permission system. When requesting authorization, you specify scopes that define exactly what your application can access.

### Available Scopes

- **users**: View user information
- **sites**: View general site information and options
- **posts**: View and manage posts
- **comments**: View and manage post comments
- **taxonomy**: View and manage tags and categories
- **follow**: Follow and unfollow blogs
- **sharing**: Connect social media services
- **freshly-pressed**: View Freshly Pressed posts
- **notifications**: View and manage user notifications
- **insights**: View analytics for your application
- **read**: Manage and view Reader subscriptions
- **stats**: View site statistics
- **media**: Manage site media
- **menus**: View and manage site menus
- **batch**: Batch multiple GET requests
- **videos**: View video information

### Special Scopes

- **global**: Grants comprehensive access to user data across all WordPress.com services and connected sites
- **auth**: Limited scope providing access only to the `/me/` endpoint for basic authentication flows. See [WordPress.com Connect](https://developer.wordpress.com/docs/api/wpcc/) for more related info.

### Scope Best Practices

Always follow the **principle of least privilege**:

```
// Request only necessary permissions
const scopes = 'posts,media'; // Not 'global' unless truly needed
```

// Request only necessary permissions const scopes = 'posts,media'; // Not 'global' unless truly neededCopyCopied

## Implementing OAuth2 Authentication

### Step 1: Authorization Request

Direct users to the authorization endpoint with the required parameters:

#### Required Parameters

- **`client_id`**: Your application’s client ID
- **`redirect_uri`**: Must match the URI registered in your application settings
- **`response_type`**: Use “code” for [Authorization Code Flow](#Authorization-Code-Flow) or “token” for [Implicit Flow](#Implicit-Flow)

#### Optional Parameters

- **`blog`**: Specific blog URL or ID for single-site access
- **`scope`**: Space-separated list of requested permissions
- **`state`**: Recommended security parameter to prevent CSRF attacks

#### Example Authorization URL

```
const authUrl = `https://public-api.wordpress.com/oauth2/authorize?` +
  `client_id=${clientId}&` +
  `redirect_uri=${encodeURIComponent(redirectUri)}&` +
  `response_type=code&` +
  `scope=posts,media&` +
  `state=${secureRandomString}`;

// // Redirect user to authorization
window.location.href = authUrl;
```

const authUrl = `https://public-api.wordpress.com/oauth2/authorize?` + `client\_id=${clientId}&amp;` + `redirect\_uri=${encodeURIComponent(redirectUri)}&amp;` + `response\_type=code&amp;` + `scope=posts,media&amp;` + `state=${secureRandomString}`; // // Redirect user to authorization window.location.href = authUrl;CopyCopied

### Step 2: Authorization Code Exchange

After user authorization, you’ll receive (at the redirect\_url location) an authorization code that must be exchanged for an access token.

#### Server-Side Token Exchange

Make a POST request to the token endpoint:

```
$curl = curl_init( 'https://public-api.wordpress.com/oauth2/token' );

curl_setopt( $curl, CURLOPT_POST, true );
curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
    'client_id' => $your_client_id,
    'redirect_uri' => $your_redirect_url,
    'client_secret' => $your_client_secret_key,
    'code' => $_GET['code'], // The authorization code
    'grant_type' => 'authorization_code'
) );

curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);

$auth = curl_exec( $curl );
$secret = json_decode( $auth );
$access_token = $secret->access_token;
```

$curl = curl\_init( 'https://public-api.wordpress.com/oauth2/token' ); curl\_setopt( $curl, CURLOPT\_POST, true ); curl\_setopt( $curl, CURLOPT\_POSTFIELDS, array( 'client\_id' =&gt; $your\_client\_id, 'redirect\_uri' =&gt; $your\_redirect\_url, 'client\_secret' =&gt; $your\_client\_secret\_key, 'code' =&gt; $\_GET\['code'\], // The authorization code 'grant\_type' =&gt; 'authorization\_code' ) ); curl\_setopt( $curl, CURLOPT\_RETURNTRANSFER, 1); $auth = curl\_exec( $curl ); $secret = json\_decode( $auth ); $access\_token = $secret-&gt;access\_token;CopyCopied

#### Successful Response

```
{
    "access_token": "YOUR_API_TOKEN",
    "blog_id": "blog_id_number",
    "blog_url": "https://yourblog.wordpress.com",
    "token_type": "bearer"
}
```

{ "access\_token": "YOUR\_API\_TOKEN", "blog\_id": "blog\_id\_number", "blog\_url": "https://yourblog.wordpress.com", "token\_type": "bearer" }CopyCopied

### Step 3: Making Authenticated API Calls

Use the Bearer token in the Authorization header for all API requests:

```
$access_token = 'YOUR_API_TOKEN';
$curl = curl_init( 'https://public-api.wordpress.com/rest/v1/me/' );

curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Authorization: Bearer ' . $access_token ) );
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );

$response = curl_exec( $curl );
```

$access\_token = 'YOUR\_API\_TOKEN'; $curl = curl\_init( 'https://public-api.wordpress.com/rest/v1/me/' ); curl\_setopt( $curl, CURLOPT\_HTTPHEADER, array( 'Authorization: Bearer ' . $access\_token ) ); curl\_setopt( $curl, CURLOPT\_RETURNTRANSFER, 1 ); $response = curl\_exec( $curl );CopyCopied

## Advanced OAuth2 Features

### Token Scope Management

Different token scopes provide different access levels:

- **Single-blog tokens**: Grant access to one specific blog
- **Global tokens**: Provide access to all user’s WordPress.com and connected Jetpack sites
- **User-specific endpoints**: Some endpoints (likes, follows) work across blogs with any user token

### Client-Side (Implicit) OAuth

For client-side applications, tokens can be returned in the URL fragment using the [Implicit Flow](#Implicit-Flow):

`https://yourapp.com/callback#access_token=TOKEN&expires_in=64800&token_type=bearer&site_id=BLOG_ID`

**Important considerations**:

- Tokens currently expire after two weeks
- Use the expires\_in value to handle token refresh
- Suitable only for public clients where secrets cannot be stored securely

### Token Validation and Management

Managing OAuth2 tokens properly is crucial for a robust application. This includes validating tokens, handling API responses, and gracefully managing token expiration or insufficient permissions.

[![Flowchart illustrating the process of validating an application token, including user identification, API requests, and handling various response scenarios such as token validity, expiration, and permission issues.](https://developer.wordpress.com/wp-content/uploads/2024/02/image-7.png?w=579)](https://developer.wordpress.com/wp-content/uploads/2024/02/image-7.png)#### Token Information Endpoint

Verify token authenticity using the token info endpoint:

`GET https://public-api.wordpress.com/oauth2/token-info?client_id=your_client_id&token=your_token`

**Valid response**:

```
{
    "client_id": "your_client_id",
    "user_id": "user_id_number",
    "blog_id": "blog_id_number",
    "scope": "posts,media"
}
```

{ "client\_id": "your\_client\_id", "user\_id": "user\_id\_number", "blog\_id": "blog\_id\_number", "scope": "posts,media" }CopyCopied

## Development and Testing

### Testing with Password Grant (Client Owners Only)

Application owners can use the [password grant](#Password-Grant) to get the authentication token:

```
$curl = curl_init( 'https://public-api.wordpress.com/oauth2/token' );

curl_setopt( $curl, CURLOPT_POST, true );

curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
    'client_id' => $your_client_id,
    'client_secret' => $your_client_secret_key,
    'grant_type' => 'password',
    'username' => $your_wpcom_username,
    'password' => $your_wpcom_password, // Use Application Password if 2FA enabled
) );

curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
$auth = curl_exec( $curl );
$auth = json_decode( $auth );
$access_token = $auth->access_token;
```

$curl = curl\_init( 'https://public-api.wordpress.com/oauth2/token' ); curl\_setopt( $curl, CURLOPT\_POST, true ); curl\_setopt( $curl, CURLOPT\_POSTFIELDS, array( 'client\_id' =&gt; $your\_client\_id, 'client\_secret' =&gt; $your\_client\_secret\_key, 'grant\_type' =&gt; 'password', 'username' =&gt; $your\_wpcom\_username, 'password' =&gt; $your\_wpcom\_password, // Use Application Password if 2FA enabled ) ); curl\_setopt( $curl, CURLOPT\_RETURNTRANSFER, 1); $auth = curl\_exec( $curl ); $auth = json\_decode( $auth ); $access\_token = $auth-&gt;access\_token;CopyCopied

**Important**: This method requires an [Application Password](https://wordpress.com/support/security/two-step-authentication/application-specific-passwords/) if two-factor authentication is enabled.

## Security Best Practices and Error Handling

### Implementation Guidelines

1. **State Parameter Validation**: Always validate the state parameter to prevent CSRF attacks
2. **Secure Token Storage**: Store access tokens securely using appropriate encryption
3. **Minimum Scope Requests**: Request only the permissions your application actually needs
4. **Clear User Communication**: Explain why specific permissions are required
5. **Proper Error Handling**: Handle authorization failures, token expiration, and scope changes gracefully

### HTTPS Requirements

All OAuth2 communications must use HTTPS to protect tokens and authorization codes during transmission.

### Token Management

- Store access tokens securely on the server side
- Implement appropriate token refresh mechanisms
- Provide clear documentation about token lifecycle
- Handle token expiration gracefully in your application

### Error Handling

Common OAuth2 errors and their meanings:

- **access\_denied**: User declined authorization
- **invalid\_client**: Invalid client credentials
- **invalid\_grant**: Invalid or expired authorization code
- **invalid\_scope**: Requested scope is invalid or unavailable

Always implement comprehensive error handling to provide users with clear feedback when authorization issues occur.

## Conclusion

OAuth2 provides a secure, user-friendly authentication method for WordPress.com integrations. By implementing proper scope management, security practices, and error handling, you can build applications that respect user privacy while providing powerful functionality. The granular permission system ensures users maintain control over their data while enabling your application to deliver valuable features.

For complete API endpoint documentation and additional examples, visit the [WordPress.com REST API Reference](https://developer.wordpress.com/docs/api/rest-api-reference).
