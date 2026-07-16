---
type: document
title: "Step 4: Develop locally"
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/develop-locally/"
tags:
timestamp: "2026-06-16T19:29:24+00:00"
wordpress:
  id: 2469
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:24"
  date_gmt: "2026-06-16 19:29:24"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: develop-locally
  parent: 2510
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/develop-locally/"
  comment_count: 0
---

[WordPress Studio](https://developer.wordpress.com/studio/?ref=developer-docs) provides convenient quick-access buttons for opening your site, plugin, and theme code directly in popular code editors like [Visual Studio Code](https://code.visualstudio.com/) and [PhpStorm](https://www.jetbrains.com/phpstorm/).

As you develop, you’ll see any file changes within the folder where you initialized a local repository appear in the “changed files” area within GitHub Desktop.

![A screenshot depicting changes in the GitHub Desktop app.](https://developer.wordpress.com/wp-content/uploads/2024/11/github-desktop-wordpress-development-hello-dolly.jpg)Depending on your workflow, you may decide to commit your changes to [different branches](https://docs.github.com/en/desktop/making-changes-in-a-branch/managing-branches-in-github-desktop#creating-a-branch) that you merge into your main branch. If you’ve been working on the main branch, and you decide to create a new branch, be sure to click the “**Bring my changes to new-branch-name**” option before clicking the “**Switch Branch**” button.

![A screenshot depicting the switch branch modal in GitHub Desktop.](https://developer.wordpress.com/wp-content/uploads/2024/11/switch-branch-github-desktop.jpg)Once you’re on the correct branch:

1. Give your commit a summary, and then click the “**Commit to new-branch name**” button.
2. Click “**Publish Branch**“.
3. Click the “**Preview Pull Request”** button, and then the **“Create Pull Request”** button.
4. Once you’re taken to GitHub in your browser, click the **“Create Pull Request”** button. It’s here that you can set up [rulesets](https://docs.github.com/en/repositories/configuring-branches-and-merges-in-your-repository/managing-rulesets/about-rulesets), [actions](https://github.com/features/actions), and/or [apps](https://github.com/marketplace/category/continuous-integration) to run prior to being able to merge any code into your main branch. You may also invite contributors, request code reviewers, and categorize the change.
5. Once you’re ready to merge the pull request to your main branch, click the “**Merge pull request”** button, and then **“Confirm merge”** button.

As a best practice and to keep your repository tidy, delete the branch by clicking the **“Delete branch”** button.

After merging your changes, the next step is to deploy them to your WordPress.com production or staging site using the [GitHub Deployments](https://developer.wordpress.com/docs/get-started/deploy/) feature.
