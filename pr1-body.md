### What this PR does / why we need it
Currently, adding a public GitLab repository throws a generic "Ooops" error because the backend defaults to GitHub (`githubApi` helper). This PR introduces proper GitLab integration parsing:
1. Adds a `gitlabApi` helper in `bootstrap/helpers/gitlab.php` to fetch and validate branches via the GitLab REST API.
2. Updates `PublicGitRepository.php` to detect `gitlab.com` URLs and route them to the seeded `GitlabApp` model.
3. Updates `GithubPrivateRepositoryDeployKey.php` to similarly detect `gitlab.com` hosts.
4. Updates the Sources UI `all.blade.php` to visibly render GitLab App connections alongside GitHub Apps.

### Testing
Manually verified that selecting "Public Repository" with a `https://gitlab.com/...` URL successfully parses the host, loads the `GitlabApp` model, and retrieves branches without throwing an exception.
