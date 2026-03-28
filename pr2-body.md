### What this PR does / why we need it
The existing `opnform` entry in `templates/service-templates.json` had a missing category (`null`) and an incorrect logo path (`svg/opnform.svg`). This PR correctly assigns it to the `productivity` category and fixes the logo path to `svgs/opnform.svg` so it renders properly in the UI.
