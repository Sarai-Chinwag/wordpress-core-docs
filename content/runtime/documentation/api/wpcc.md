---
type: document
title: WordPress.com Connect
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/wpcc/"
tags:
timestamp: "2026-06-16T19:29:26+00:00"
wordpress:
  id: 2489
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:26"
  date_gmt: "2026-06-16 19:29:26"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: wpcc
  parent: 2499
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/wpcc/"
  comment_count: 0
---

WordPress.com Connect is a streamlined authentication solution designed specifically for **“Login with WordPress.com”** functionality. It provides a secure and user-friendly way for millions of WordPress.com users to authenticate with your application using their existing WordPress.com credentials.

![Image showing the Connect with WordPress.com button.](//s0.wp.com/i/wpcc-button.png)WordPress.com Connect is a specialized implementation of OAuth2 focused on user authentication and identity verification. For full API access to WordPress.com sites and content management, see the complete [OAuth2 Authentication](https://developer.wordpress.com/docs/api/oauth2) documentation.

WordPress.com Connect allows WordPress.com users to quickly log in to your service without creating new accounts. When users connect, your application receives their basic profile information (name, email, avatar) while they maintain control over their WordPress.com data and privacy.

**Key characteristics of WordPress.com Connect**:

- **User-friendly**: Familiar interface for millions of WordPress.com users<a name="benefits"></a>
- **Identity-focused**: Designed for user authentication, not content management
- **Limited scope**: Access restricted to basic profile information via the `/me/` endpoint
- **Simplified flow**: Optimized for “Login with WordPress.com” buttons

## Benefits

**Millions Of Users** – WordPress.com consists of millions of users and is growing every day. By adding WordPress.com Connect you will become part of a large family that makes it easy for WordPress.com users to explore new services.

**Compatible with your existing sign-in system** – WordPress.com Connect can be used on its own or as a complimentary sign-in option to your existing registration system. Once a user connects, you will get access to their profile information which you can use in your own app.

**Trusted Relationship** – Allow users to sign-in with the same credentials they use every day on WordPress.com. This takes the pain out of having to remember and manage a new log-in for another service.

 For practical implementation examples of WordPress.com Connect in different programming languages, check out the [wpcom-connect-examples repository](https://github.com/Automattic/wpcom-connect-examples). This repository contains sample code demonstrating how to implement “Login with WordPress.com” functionality across various languages and frameworks.

## OAuth2 Implementation Details

WordPress.com Connect uses the **OAuth2 Authentication Endpoint** (`/oauth2/authenticate`) rather than the standard authorization endpoint. This specialized endpoint is optimized for identity verification and automatically limits token scope to basic profile access.

**Technical Flow**:

1. **User Authorization**: Redirect to `/oauth2/authenticate` (not `/oauth2/authorize`)
2. **Code Exchange**: Exchange authorization code at `/oauth2/token` (same as full OAuth2)
3. **Limited Access**: Resulting token provides access only to `/me/` endpoint
4. **Profile Data**: Retrieve user identity from `/rest/v1.1/me`

 For detailed technical information about the `/oauth2/authenticate` endpoint, see the [Authentication Endpoint section](https://developer.wordpress.com/docs/api/oauth2/#Authentication-Endpoint) in the OAuth2 documentation.

## Prerequisites

Before implementing WordPress.com Connect, you need to register your application:

1. **Create a WordPress.com Application** at [developer.wordpress.com/apps](https://developer.wordpress.com/apps/)
2. **Configure your application**: Use the same title as your website (shown in login forms)
3. **Obtain credentials**: You’ll receive a `CLIENT_ID` and `CLIENT_SECRET`
4. **Set redirect URI**: Configure where users return after authentication

## Implementation Example (PHP)

Here’s a complete example demonstrating how to implement WordPress.com Connect for user authentication and profile retrieval.

### Configuration Setup

First, configure your application credentials. Replace these values with those from your [WordPress.com Application](https://developer.wordpress.com/apps/):

```
<?php
// config.php - WordPress.com Connect Configuration
define('CLIENT_ID', 'your_client_id');
define('CLIENT_SECRET', 'your_client_secret');
define('REDIRECT_URI', 'https://yourapp.com/auth-callback');

// WordPress.com OAuth2 endpoints (no changes needed)
define('AUTHENTICATE_URL', 'https://public-api.wordpress.com/oauth2/authenticate');
define('TOKEN_URL', 'https://public-api.wordpress.com/oauth2/token');
define('USER_INFO_URL', 'https://public-api.wordpress.com/rest/v1.1/me');

session_start(); // Required for state parameter security
?>
```

&lt;?php // config.php - WordPress.com Connect Configuration define('CLIENT\_ID', 'your\_client\_id'); define('CLIENT\_SECRET', 'your\_client\_secret'); define('REDIRECT\_URI', 'https://yourapp.com/auth-callback'); // WordPress.com OAuth2 endpoints (no changes needed) define('AUTHENTICATE\_URL', 'https://public-api.wordpress.com/oauth2/authenticate'); define('TOKEN\_URL', 'https://public-api.wordpress.com/oauth2/token'); define('USER\_INFO\_URL', 'https://public-api.wordpress.com/rest/v1.1/me'); session\_start(); // Required for state parameter security ?&gt;CopyCopied

 **Complete example**: See the [wpcom-connect-examples repository](https://github.com/Automattic/wpcom-connect-examples/blob/master/php/config.php) for additional language implementations.

### Step 1: Create Authorization URL

Generate the “Connect with WordPress.com” button that redirects users to WordPress.com for authentication. This uses the **authentication endpoint** (not the standard authorization endpoint).

**Security Note**: The `state` parameter prevents CSRF attacks and must be validated when users return.

```
<?php
require_once 'config.php';

// Generate secure state parameter for CSRF protection
if (!isset($_SESSION['wpcc_state'])) {
    $_SESSION['wpcc_state'] = bin2hex(random_bytes(16)); // More secure than md5(mt_rand())
}

// Build authentication URL using /oauth2/authenticate endpoint
$auth_url = AUTHENTICATE_URL . '?' . http_build_query([
    'response_type' => 'code',
    'client_id'     => CLIENT_ID,
    'redirect_uri'  => REDIRECT_URI,
    'state'         => $_SESSION['wpcc_state'],
    'scope'         => 'auth' // Limited scope for profile access only
]);

// Display the Connect button
echo '<a href="' . htmlspecialchars($auth_url) . '">';
echo '<img src="https://s0.wp.com/i/wpcc-button.png" width="231" alt="Connect with WordPress.com" />';
echo '</a>';
?>
```

&lt;?php require\_once 'config.php'; // Generate secure state parameter for CSRF protection if (!isset($\_SESSION\['wpcc\_state'\])) { $\_SESSION\['wpcc\_state'\] = bin2hex(random\_bytes(16)); // More secure than md5(mt\_rand()) } // Build authentication URL using /oauth2/authenticate endpoint $auth\_url = AUTHENTICATE\_URL . '?' . http\_build\_query(\[ 'response\_type' =&gt; 'code', 'client\_id' =&gt; CLIENT\_ID, 'redirect\_uri' =&gt; REDIRECT\_URI, 'state' =&gt; $\_SESSION\['wpcc\_state'\], 'scope' =&gt; 'auth' // Limited scope for profile access only \]); // Display the Connect button echo '&lt;a href="' . htmlspecialchars($auth\_url) . '"&gt;'; echo '&lt;img src="https://s0.wp.com/i/wpcc-button.png" width="231" alt="Connect with WordPress.com" /&gt;'; echo '&lt;/a&gt;'; ?&gt;CopyCopied

This generates the familiar WordPress.com Connect button:

![Image showing the Connect with WordPress.com button.](https://s0.wp.com/i/wpcc-button.png)### Step 2: Handle Authorization Response

When users click the Connect button, they see a WordPress.com authorization screen:

![WordPress login prompt asking users to approve access for Test Company, detailing information that will be viewed, with options to approve or deny.](https://wpdeveloperstaging.files.wordpress.com/2024/02/e124d-oauth-approve.png)After approval, WordPress.com redirects users back to your `redirect_uri` with an authorization code. Your callback handler must validate the state parameter and exchange the code for an access token:

```
<?php
// auth-callback.php - Handle the authorization response
require_once 'config.php';

// Validate authorization response
if (!isset($_GET['code'])) {
    die('Error: No authorization code received. User may have declined access.');
}

if (!isset($_GET['state']) || $_GET['state'] !== $_SESSION['wpcc_state']) {
    die('Error: State mismatch. Possible CSRF attack detected.');
}

// Exchange authorization code for access token
$curl = curl_init(TOKEN_URL);
curl_setopt_array($curl, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => [
        'client_id'     => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'code'          => $_GET['code'],
        'grant_type'    => 'authorization_code',
        'redirect_uri'  => REDIRECT_URI
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => true
]);

$response = curl_exec($curl);
$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($http_code !== 200) {
    die('Error: Failed to obtain access token.');
}

$token_data = json_decode($response, true);
$access_token = $token_data['access_token'];

// Clean up session state
unset($_SESSION['wpcc_state']);
?>
```

&lt;?php // auth-callback.php - Handle the authorization response require\_once 'config.php'; // Validate authorization response if (!isset($\_GET\['code'\])) { die('Error: No authorization code received. User may have declined access.'); } if (!isset($\_GET\['state'\]) || $\_GET\['state'\] !== $\_SESSION\['wpcc\_state'\]) { die('Error: State mismatch. Possible CSRF attack detected.'); } // Exchange authorization code for access token $curl = curl\_init(TOKEN\_URL); curl\_setopt\_array($curl, \[ CURLOPT\_POST =&gt; true, CURLOPT\_POSTFIELDS =&gt; \[ 'client\_id' =&gt; CLIENT\_ID, 'client\_secret' =&gt; CLIENT\_SECRET, 'code' =&gt; $\_GET\['code'\], 'grant\_type' =&gt; 'authorization\_code', 'redirect\_uri' =&gt; REDIRECT\_URI \], CURLOPT\_RETURNTRANSFER =&gt; true, CURLOPT\_SSL\_VERIFYPEER =&gt; true \]); $response = curl\_exec($curl); $http\_code = curl\_getinfo($curl, CURLINFO\_HTTP\_CODE); curl\_close($curl); if ($http\_code !== 200) { die('Error: Failed to obtain access token.'); } $token\_data = json\_decode($response, true); $access\_token = $token\_data\['access\_token'\]; // Clean up session state unset($\_SESSION\['wpcc\_state'\]); ?&gt;CopyCopied

**Successful token response**:

```
{
    "access_token": "your_access_token_here",
    "token_type": "bearer",
    "blog_id": 0,
    "blog_url": "https://public-api.wordpress.com",
    "scope": "auth"
}
```

{ "access\_token": "your\_access\_token\_here", "token\_type": "bearer", "blog\_id": 0, "blog\_url": "https://public-api.wordpress.com", "scope": "auth" }CopyCopied

Note the `scope: "auth"` – this confirms the token has limited access for identity verification only.

### Step 3: Retrieve User Profile

With the access token, retrieve the user’s profile information from the [`/me/` endpoint](https://developer.wordpress.com/docs/api/1/get/me/):

```
<?php
// Fetch user profile using the access token
function get_user_profile($access_token) {
    $curl = curl_init(USER_INFO_URL);
    curl_setopt_array($curl, [
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $access_token
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => true // Always verify SSL in production
    ]);

    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($http_code !== 200) {
        throw new Exception('Failed to fetch user profile');
    }

    return json_decode($response, true);
}

// Get the user's WordPress.com profile
try {
    $user_profile = get_user_profile($access_token);

    // Store or process user information
    $user_id = $user_profile['ID'];
    $display_name = $user_profile['display_name'];
    $email = $user_profile['email'];
    $avatar_url = $user_profile['avatar_URL'];
    $is_verified = $user_profile['verified'];

} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>
```

&lt;?php // Fetch user profile using the access token function get\_user\_profile($access\_token) { $curl = curl\_init(USER\_INFO\_URL); curl\_setopt\_array($curl, \[ CURLOPT\_HTTPHEADER =&gt; \[ 'Authorization: Bearer ' . $access\_token \], CURLOPT\_RETURNTRANSFER =&gt; true, CURLOPT\_SSL\_VERIFYPEER =&gt; true // Always verify SSL in production \]); $response = curl\_exec($curl); $http\_code = curl\_getinfo($curl, CURLINFO\_HTTP\_CODE); curl\_close($curl); if ($http\_code !== 200) { throw new Exception('Failed to fetch user profile'); } return json\_decode($response, true); } // Get the user's WordPress.com profile try { $user\_profile = get\_user\_profile($access\_token); // Store or process user information $user\_id = $user\_profile\['ID'\]; $display\_name = $user\_profile\['display\_name'\]; $email = $user\_profile\['email'\]; $avatar\_url = $user\_profile\['avatar\_URL'\]; $is\_verified = $user\_profile\['verified'\]; } catch (Exception $e) { die('Error: ' . $e-&gt;getMessage()); } ?&gt;CopyCopied

**Profile response format**:

```
{
  "ID": 12345,
  "display_name": "Bob Smith",
  "username": "bobsmith",
  "email": "bob@example.com",
  "primary_blog": 67890,
  "avatar_URL": "https://gravatar.com/avatar/abc123?s=96",
  "profile_URL": "https://en.gravatar.com/bobsmith",
  "verified": true
}
```

{ "ID": 12345, "display\_name": "Bob Smith", "username": "bobsmith", "email": "bob@example.com", "primary\_blog": 67890, "avatar\_URL": "https://gravatar.com/avatar/abc123?s=96", "profile\_URL": "https://en.gravatar.com/bobsmith", "verified": true }CopyCopied

### Step 4: Complete User Authentication

Once you have the user profile, integrate them into your application:

```
<?php
// Complete user authentication flow
if ($is_verified) {
    // User has verified their email - safe to trust profile data
    $existing_user = find_user_by_wpcom_id($user_id);

    if ($existing_user) {
        // Log in existing user
        login_user($existing_user);
        redirect_to_dashboard();
    } else {
        // Create new account with WordPress.com profile data
        $new_user = create_user([
            'wpcom_id' => $user_id,
            'username' => $user_profile['username'],
            'email' => $email,
            'display_name' => $display_name,
            'avatar_url' => $avatar_url
        ]);
        login_user($new_user);
        redirect_to_welcome();
    }
} else {
    // Unverified email - handle with caution
    redirect_to_verification_required();
}
?>
```

&lt;?php // Complete user authentication flow if ($is\_verified) { // User has verified their email - safe to trust profile data $existing\_user = find\_user\_by\_wpcom\_id($user\_id); if ($existing\_user) { // Log in existing user login\_user($existing\_user); redirect\_to\_dashboard(); } else { // Create new account with WordPress.com profile data $new\_user = create\_user(\[ 'wpcom\_id' =&gt; $user\_id, 'username' =&gt; $user\_profile\['username'\], 'email' =&gt; $email, 'display\_name' =&gt; $display\_name, 'avatar\_url' =&gt; $avatar\_url \]); login\_user($new\_user); redirect\_to\_welcome(); } } else { // Unverified email - handle with caution redirect\_to\_verification\_required(); } ?&gt;CopyCopied

**Important**: Always check the `verified` flag before trusting profile information. Unverified accounts may contain unreliable data.

## WordPress.com Connect vs Full OAuth2

Understanding when to use each approach:

| Feature | WordPress.com Connect | Full OAuth2 |
|---|---|---|
| **Purpose** | User authentication &amp; identity | Full API access &amp; content management |
| **Endpoint** | `/oauth2/authenticate` | `/oauth2/authorize` |
| **Token Scope** | `auth` (limited to `/me/`) | Custom scopes (`posts`, `media`, etc.) |
| **Use Cases** | “Login with WordPress.com” | WordPress.com site management |
| **Data Access** | Basic profile only | Blog posts, media, comments, etc. |

**Important**: Do not use the same WordPress.com application for both Connect authentication and full API access. Connect tokens are limited to the `/me/` endpoint and cannot access blog content or management features.<a name="get_started"></a>
