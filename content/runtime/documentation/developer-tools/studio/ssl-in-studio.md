---
type: document
title: SSL in Studio
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/ssl-in-studio/"
tags:
timestamp: "2026-06-16T19:29:22+00:00"
wordpress:
  id: 2458
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:22"
  date_gmt: "2026-06-16 19:29:22"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: ssl-in-studio
  parent: 2481
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/ssl-in-studio/"
  comment_count: 0
---

WordPress Studio includes support for HTTPS, allowing you to create sites with secure connections that more closely resemble production environments. This feature makes your local development experience more realistic and helps identify potential issues that might only occur with HTTPS.

## Overview

The SSL support feature in WordPress Studio enables:

- Creating sites with HTTPS enabled
- Using custom domains with proper SSL certificates
- Automatic certificate management
- Browser compatibility without security warnings (when trusted)

## How it works

WordPress Studio implements SSL support through the following components:

- **Certificate Authority (CA)**: Studio creates its own Certificate Authority that signs certificates for your local sites.
- **Domain Certificates**: Each site with HTTPS enabled receives its own certificate signed by the CA.
- **Certificate Trust**: The system helps you trust the certificate on your operating system.
- **HTTPS Redirection**: Traffic is automatically redirected from HTTP to HTTPS for sites with SSL enabled.

## Enabling HTTPS for a site

Note that HTTPS requires a custom domain, as it cannot be used with the default localhost address.

To enable HTTPS for a new or existing site:

1. Start by creating a new site or editing an existing site using the “**Edit site**” button on the **Settings** tab.
2. If creating a new site, toggle “**Advanced setting**” in the modal that appears.
3. Check the “**Use custom domain**” option.
4. If you have not already provided one, enter a domain name (must end with `.local`) or use the automatically generated one.
5. Check the “**Enable HTTPS**” option.

![A screenshot depicting how to enable HTTPS when creating a new Studio site.](https://developer.wordpress.com/wp-content/uploads/2025/03/studio-custom-domain-ssl-docs.jpg)1. Click the “**Add site**” or **Save** button, depending on whether you are creating a new site or editing an existing one.
2. When prompted, give your permission for WordPress Studio to modify the system hosts file. Studio will configure everything else automatically.
3. For HTTPS connections, a root certificate authority will be generated and installed. On MacOS, you’ll need to manually install the certificate to avoid browser warnings. [Refer to the guide below for more details](#macos).
4. Navigate to your site using the custom domain.

## Certificate Trust by platform

### Windows

On Windows, WordPress Studio automatically adds the CA to your system trust store. This process requires administrator privileges, so you may see a User Account Control (UAC) prompt when enabling HTTPS.

### MacOS

On macOS, you need to manually trust the CA. To do this, find the certificate file that Studio automatically installs on your system:

1. Navigate to the Settings tab of the site with SSL enabled.
2. Click on the “**Trust Certificate**” link under **Site Details**.

![](https://developer.wordpress.com/wp-content/uploads/2025/03/ssl-trust-certificate.png)1. This will open the folder containing the certificate file (`studio-ca.crt`). Double-click the file to install the certificate and automatically open the **Keychain Access** tool on your machine.
2. Locate the **WordPress Studio CA** certificate. You can filter the items by the word `studio`.

![A screenshot depicting the Keychain Access application on a Mac and the WordPress Studio CA certificate.](https://developer.wordpress.com/wp-content/uploads/2025/03/ssl-keychain.png)1. Double-click the certificate and expand the **Trust** section.
2. Set “**Secure Sockets Layer(SSL)**” to *“***Always Trust**.” You can leave all other settings the same.

![A screenshot depicting the Keychain Access application on a Mac and how to set the SSL setting to "Always Trust" on the WordPress Studio CA certificate.](https://developer.wordpress.com/wp-content/uploads/2025/03/ssl-certificate-always-trust.png)1. Close the dialog and enter your password to confirm.

Once the certificate is trusted, your browser will recognize it and indicate that your HTTPS sites are secure.

### Linux

On Linux, Studio automatically imports the root certificate authority (CA) into the system bundle, Chromium-family user NSS databases, and existing Firefox profile NSS databases (apt, Snap, and Flatpak installs) when you click **Trust Certificate**. Most users will not need the steps below.

Use this fallback only if auto-trust didn’t take effect.

#### Firefox (GUI)

1. Open `about:preferences#privacy`.
2. Scroll to **Certificates** and click **View Certificates…**.

[![](https://developer.wordpress.com/wp-content/uploads/2025/03/cleanshot-2026-05-18-at-11.54.43402x.png?w=1024)](https://developer.wordpress.com/wp-content/uploads/2025/03/cleanshot-2026-05-18-at-11.54.43402x.png)3\. Switch to the **Authorities** tab and click **Import…**.

1. 

[![](https://developer.wordpress.com/wp-content/uploads/2025/03/cleanshot-2026-05-18-at-11.54.52402x.png?w=1024)](https://developer.wordpress.com/wp-content/uploads/2025/03/cleanshot-2026-05-18-at-11.54.52402x.png)4\. Select `~/.studio/certificates/studio-ca.crt`.

5\. Check **Trust this CA to identify websites** and click **OK**.

1. 

[![](https://developer.wordpress.com/wp-content/uploads/2025/03/cleanshot-2026-05-18-at-11.55.19402x.png?w=1024)](https://developer.wordpress.com/wp-content/uploads/2025/03/cleanshot-2026-05-18-at-11.55.19402x.png)6\. Fully quit and relaunch Firefox.

1. 

#### Chromium / Chrome / Brave / Edge (CLI)

Install `certutil` if it isn’t already available:

 ```shell
sudo apt install libnss3-tools
```

 

 

Import the CA into the user NSS database:

 ```shell
certutil -d sql:$HOME/.pki/nssdb -A -t 'C,,' -n 'WordPress Studio CA' -i ~/.studio/certificates/studio-ca.crt
```

 

 

For Snap-Chromium, use the Snap-specific NSS database path instead:

 ```shell
certutil -d sql:$HOME/snap/chromium/current/.pki/nssdb -A -t 'C,,' -n 'WordPress Studio CA' -i ~/.studio/certificates/studio-ca.crt
```

 

 

Fully quit and relaunch the browser after import.

## Troubleshooting

### Browser security warnings

If you see browser security warnings when visiting your HTTPS-enabled site:

- Ensure you’ve trusted the **WordPress Studio CA** certificate on your system.
- Restart your browser after trusting the certificate.
- Clear your browser cache if warnings persist.
