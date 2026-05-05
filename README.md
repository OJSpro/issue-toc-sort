# Issue Article Sort Plugin for OJS 3.4

The **Issue Article Sort** plugin provides flexible options for organizing how articles are displayed within an issue's Table of Contents in **Open Journal Systems (OJS) 3.4**.

## Features

-   **Multiple Sorting Criteria**: Choose how to order articles within their respective sections:
    -   **Alphabetical**: Sort articles by title from A to Z.
    -   **Reverse Alphabetical**: Sort articles by title from Z to A.
    -   **Page Range**: Sort articles numerically by their starting page number.
    -   **Date Published (Oldest First)**: Order articles by their original publication date.
    -   **Date Published (Newest First)**: Show the most recently published articles first.
-   **Seamless Integration**: Hooks directly into the frontend issue display (`issue.tpl`) to reorder the `publishedSubmissions` array before it is rendered.
-   **Easy Configuration**: Simple settings form accessible via the plugin management interface.

## Installation

1.  Download the `issuearticlesort.tar.gz` package.
2.  Log in as a Journal Manager or Site Administrator.
3.  Navigate to **Settings > Website > Plugins**.
4.  Click **Upload A New Plugin** and select the `.tar.gz` file.
5.  Find the **Issue Article Sort** plugin in the Generic Plugins list and enable it.

## How to Use

1.  Go to **Settings > Website > Plugins**.
2.  Locate **Issue Article Sort** and click the blue arrow next to it, then select **Settings**.
3.  Select your preferred **Sort Order** from the dropdown menu.
4.  Click **Save**.
5.  The new sorting order will immediately apply to all issue Table of Contents pages on your journal.

## Requirements

-   **OJS 3.4.x**
-   PHP 8.0 or higher.

## License

This plugin is licensed under the GNU General Public License v3.

---
Developed by [OJSpro](https://github.com/OJSpro)
