# Issue Article Sort Plugin for OJS 3.x

## Overview
The **Issue Article Sort** plugin allows journal managers to automatically control the display order of articles within an issue on the public frontend. Instead of relying on manual drag-and-drop sorting for every issue, this plugin applies a consistent sorting logic site-wide (or journal-wide).

## Key Features
- **Automated Sorting**: Automatically reorders articles within their respective sections when an issue page is loaded.
- **Multiple Sorting Criteria**:
  - **Alphabetical**: Sort articles by title (A-Z).
  - **Alphabetical Reverse**: Sort articles by title (Z-A).
  - **Author Alphabetical**: Sort by the primary author's name (A-Z).
  - **Author Alphabetical Reverse**: Sort by the primary author's name (Z-A).
  - **Page Range**: Sort numerically based on starting page numbers.
  - **Date Published**: Sort by the original publication date (Oldest first).
  - **Date Published Reverse**: Sort by the original publication date (Newest first).
- **Section-Aware**: Sorting is applied independently within each section (e.g., Articles, Reviews, etc.), preserving the section hierarchy defined in the issue.

## Installation

### Manual Installation
1. Download the plugin files.
2. Place the `issuearticlesort` folder into the `plugins/generic/` directory of your OJS installation.
3. Log in as a Journal Manager.
4. Navigate to **Settings > Website > Plugins**.
5. Locate **Issue Article Sort** and check the box to **Enable** it.

## Configuration
1. Go to **Settings > Website > Plugins**.
2. Find the **Issue Article Sort** plugin under **Generic Plugins**.
3. Click the blue arrow next to the plugin name and select **Settings**.
4. Choose your preferred **Sort Order** from the dropdown menu.
5. Click **Save**.

The selected sorting logic will immediately apply to all published issues on the frontend.

## How it Works
The plugin hooks into the template display process for the issue page. It intercepts the list of published submissions, applies the chosen sorting algorithm via PHP's `usort`, and updates the template variables before the page is rendered. This ensures that the underlying database order remains unchanged while the presentation is perfectly tailored to your preference.

## License
Distributed under the GNU GPL v3. For full terms, see the file `docs/COPYING`.

## Support
For issues or feature requests, please contact the repository maintainers.
