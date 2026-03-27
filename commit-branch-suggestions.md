# Commit And Branch Suggestions

Generated from `git status --short --untracked-files=all` on 2026-03-24.

Total non-ignored uncommitted files: **240**

| File | Git status | Suggested commit message | Suggested branch | Note |
| --- | --- | --- | --- | --- |
| `app/Models/Comment.php` | `M` | feat: update Comment model | `feat/app-models-comment` |  |
| `app/Models/Project.php` | `M` | feat: update Project model | `feat/app-models-project` |  |
| `app/Models/Task.php` | `M` | feat: update Task model | `feat/app-models-task` |  |
| `app/Models/User.php` | `M` | feat: update User model | `feat/app-models-user` |  |
| `boost.json` | `M` | chore: update Boost workspace configuration | `chore/update-boost-config` |  |
| `bootstrap/app.php` | `M` | feat: update application bootstrap configuration | `feat/update-bootstrap-app` |  |
| `bootstrap/providers.php` | `M` | feat: update registered service providers | `feat/update-bootstrap-providers` |  |
| `composer.json` | `M` | build: update PHP package dependencies and scripts | `build/update-composer-config` |  |
| `database/migrations/2026_03_05_161711_create_projects_table.php` | `M` | feat: add migration to create projects table | `feat/database-migrations-2026-03-05-161711-create-projects-table` |  |
| `database/migrations/2026_03_05_161721_create_tasks_table.php` | `M` | feat: add migration to create tasks table | `feat/database-migrations-2026-03-05-161721-create-tasks-table` |  |
| `package-lock.json` | `M` | build: lock frontend dependency versions | `build/update-package-lock` |  |
| `package.json` | `M` | build: update frontend package configuration | `build/update-package-config` |  |
| `public/build/manifest.json` | `M` | build: update manifest asset manifest | `build/public-build-manifest` | Generated asset; commit only if your workflow tracks compiled output. |
| `routes/web.php` | `M` | feat: update web route definitions | `feat/update-web-routes` |  |
| `vite.config.js` | `M` | build: update Vite configuration | `build/update-vite-config` |  |
| `.DS_Store` | `??` | chore: remove macOS Finder metadata from repository root | `chore/ignore-root-ds-store` | Usually should be deleted or ignored instead of committed. |
| `.cursor/mcp.json` | `??` | docs: add mcp development guidance | `docs/cursor-mcp` |  |
| `.cursor/skills/fluxui-development/SKILL.md` | `??` | docs: add skill development guidance | `docs/cursor-skills-fluxui-development-skill` |  |
| `.cursor/skills/livewire-development/SKILL.md` | `??` | docs: add skill development guidance | `docs/cursor-skills-livewire-development-skill` |  |
| `.cursor/skills/livewire-development/reference/javascript-hooks.md` | `??` | docs: add javascript hooks development guidance | `docs/cursor-skills-livewire-development-reference-javascript-hooks` |  |
| `.cursor/skills/pest-testing/SKILL.md` | `??` | docs: add skill development guidance | `docs/cursor-skills-pest-testing-skill` |  |
| `.cursor/skills/tailwindcss-development/SKILL.md` | `??` | docs: add skill development guidance | `docs/cursor-skills-tailwindcss-development-skill` |  |
| `.editorconfig` | `??` | chore: add shared editor formatting rules | `chore/add-editorconfig` |  |
| `.env.example` | `??` | chore: add example environment configuration | `chore/add-env-example` |  |
| `.gitattributes` | `??` | chore: add git attributes configuration | `chore/add-gitattributes` |  |
| `.github/workflows/lint.yml` | `??` | ci: add lint workflow | `ci/lint` |  |
| `.github/workflows/tests.yml` | `??` | ci: add tests workflow | `ci/tests` |  |
| `.gitignore` | `??` | chore: add repository ignore rules | `chore/add-gitignore` |  |
| `AGENTS.md` | `??` | docs: add contributor agent instructions | `docs/add-agents-guide` |  |
| `app/.DS_Store` | `??` | chore: remove macOS Finder metadata from app | `chore/ignore-app-ds-store` | Usually should be deleted or ignored instead of committed. |
| `app/DTOS/CommentDTO.php` | `??` | feat: add Comment DTO DTO | `feat/app-dtos-commentdto` |  |
| `app/DTOS/LoginDTO.php` | `??` | feat: add Login DTO DTO | `feat/app-dtos-logindto` |  |
| `app/DTOS/ProjectDTO.php` | `??` | feat: add Project DTO DTO | `feat/app-dtos-projectdto` |  |
| `app/DTOS/TaskDTO.php` | `??` | feat: add Task DTO DTO | `feat/app-dtos-taskdto` |  |
| `app/DTOS/UserDTO.php` | `??` | feat: add User DTO DTO | `feat/app-dtos-userdto` |  |
| `app/Enums/ProjectStatus.php` | `??` | feat: add Project Status enum | `feat/app-enums-projectstatus` |  |
| `app/Enums/TaskPriority.php` | `??` | feat: add Task Priority enum | `feat/app-enums-taskpriority` |  |
| `app/Enums/TaskStatus.php` | `??` | feat: add Task Status enum | `feat/app-enums-taskstatus` |  |
| `app/Enums/UserRole.php` | `??` | feat: add User Role enum | `feat/app-enums-userrole` |  |
| `app/Filament/Resources/ActivityLogs/ActivityLogResource.php` | `??` | feat: add Filament activity log resource | `feat/app-filament-resources-activitylogs-activitylogresource` |  |
| `app/Filament/Resources/ActivityLogs/Pages/ListActivityLogs.php` | `??` | chore: add list activity logs | `feat/app-filament-resources-activitylogs-pages-listactivitylogs` |  |
| `app/Filament/Resources/ActivityLogs/Tables/ActivityLogsTable.php` | `??` | chore: add activity logs table | `feat/app-filament-resources-activitylogs-tables-activitylogstable` |  |
| `app/Filament/Resources/Comments/CommentResource.php` | `??` | feat: add Filament comment resource | `feat/app-filament-resources-comments-commentresource` |  |
| `app/Filament/Resources/Comments/Pages/CreateComment.php` | `??` | chore: add create comment | `feat/app-filament-resources-comments-pages-createcomment` |  |
| `app/Filament/Resources/Comments/Pages/EditComment.php` | `??` | chore: add edit comment | `feat/app-filament-resources-comments-pages-editcomment` |  |
| `app/Filament/Resources/Comments/Pages/ListComments.php` | `??` | chore: add list comments | `feat/app-filament-resources-comments-pages-listcomments` |  |
| `app/Filament/Resources/Comments/Schemas/CommentForm.php` | `??` | chore: add comment form | `feat/app-filament-resources-comments-schemas-commentform` |  |
| `app/Filament/Resources/Comments/Tables/CommentsTable.php` | `??` | chore: add comments table | `feat/app-filament-resources-comments-tables-commentstable` |  |
| `app/Filament/Resources/Notifications/NotificationResource.php` | `??` | feat: add Filament notification resource | `feat/app-filament-resources-notifications-notificationresource` |  |
| `app/Filament/Resources/Notifications/Pages/ListNotifications.php` | `??` | chore: add list notifications | `feat/app-filament-resources-notifications-pages-listnotifications` |  |
| `app/Filament/Resources/Notifications/Tables/NotificationsTable.php` | `??` | chore: add notifications table | `feat/app-filament-resources-notifications-tables-notificationstable` |  |
| `app/Filament/Resources/Projects/Pages/CreateProject.php` | `??` | chore: add create project | `feat/app-filament-resources-projects-pages-createproject` |  |
| `app/Filament/Resources/Projects/Pages/EditProject.php` | `??` | chore: add edit project | `feat/app-filament-resources-projects-pages-editproject` |  |
| `app/Filament/Resources/Projects/Pages/ListProjects.php` | `??` | chore: add list projects | `feat/app-filament-resources-projects-pages-listprojects` |  |
| `app/Filament/Resources/Projects/ProjectResource.php` | `??` | feat: add Filament project resource | `feat/app-filament-resources-projects-projectresource` |  |
| `app/Filament/Resources/Projects/Schemas/ProjectForm.php` | `??` | chore: add project form | `feat/app-filament-resources-projects-schemas-projectform` |  |
| `app/Filament/Resources/Projects/Tables/ProjectsTable.php` | `??` | chore: add projects table | `feat/app-filament-resources-projects-tables-projectstable` |  |
| `app/Filament/Resources/Tasks/Pages/CreateTask.php` | `??` | chore: add create task | `feat/app-filament-resources-tasks-pages-createtask` |  |
| `app/Filament/Resources/Tasks/Pages/EditTask.php` | `??` | chore: add edit task | `feat/app-filament-resources-tasks-pages-edittask` |  |
| `app/Filament/Resources/Tasks/Pages/ListTasks.php` | `??` | chore: add list tasks | `feat/app-filament-resources-tasks-pages-listtasks` |  |
| `app/Filament/Resources/Tasks/Schemas/TaskForm.php` | `??` | chore: add task form | `feat/app-filament-resources-tasks-schemas-taskform` |  |
| `app/Filament/Resources/Tasks/Tables/TasksTable.php` | `??` | chore: add tasks table | `feat/app-filament-resources-tasks-tables-taskstable` |  |
| `app/Filament/Resources/Tasks/TaskResource.php` | `??` | feat: add Filament task resource | `feat/app-filament-resources-tasks-taskresource` |  |
| `app/Filament/Resources/Users/Pages/CreateUser.php` | `??` | chore: add create user | `feat/app-filament-resources-users-pages-createuser` |  |
| `app/Filament/Resources/Users/Pages/EditUser.php` | `??` | chore: add edit user | `feat/app-filament-resources-users-pages-edituser` |  |
| `app/Filament/Resources/Users/Pages/ListUsers.php` | `??` | chore: add list users | `feat/app-filament-resources-users-pages-listusers` |  |
| `app/Filament/Resources/Users/Schemas/UserForm.php` | `??` | chore: add user form | `feat/app-filament-resources-users-schemas-userform` |  |
| `app/Filament/Resources/Users/Tables/UsersTable.php` | `??` | chore: add users table | `feat/app-filament-resources-users-tables-userstable` |  |
| `app/Filament/Resources/Users/UserResource.php` | `??` | feat: add Filament user resource | `feat/app-filament-resources-users-userresource` |  |
| `app/Filament/Widgets/ProjectStatsOverview.php` | `??` | feat: add Filament project stats overview widget | `feat/app-filament-widgets-projectstatsoverview` |  |
| `app/Http/Controllers/Api/AuthController.php` | `??` | feat: add API auth controller | `feat/app-http-controllers-api-authcontroller` |  |
| `app/Http/Controllers/Api/CommentController.php` | `??` | feat: add API comment controller | `feat/app-http-controllers-api-commentcontroller` |  |
| `app/Http/Controllers/Api/ProjectController.php` | `??` | feat: add API project controller | `feat/app-http-controllers-api-projectcontroller` |  |
| `app/Http/Controllers/Api/TaskController.php` | `??` | feat: add API task controller | `feat/app-http-controllers-api-taskcontroller` |  |
| `app/Http/Controllers/Controller.php` | `??` | feat: add base application controller | `feat/add-base-controller` |  |
| `app/Http/Controllers/Web/CommentController.php` | `??` | feat: add web comment controller | `feat/app-http-controllers-web-commentcontroller` |  |
| `app/Http/Controllers/Web/DashboardController.php` | `??` | feat: add web dashboard controller | `feat/app-http-controllers-web-dashboardcontroller` |  |
| `app/Http/Controllers/Web/ProjectController.php` | `??` | feat: add web project controller | `feat/app-http-controllers-web-projectcontroller` |  |
| `app/Http/Controllers/Web/TaskController.php` | `??` | feat: add web task controller | `feat/app-http-controllers-web-taskcontroller` |  |
| `app/Http/Middleware/RoleMiddleware.php` | `??` | feat: add role middleware | `feat/app-http-middleware-rolemiddleware` |  |
| `app/Http/Requests/ChangeTaskStatusRequest.php` | `??` | feat: add change task status request validation | `feat/app-http-requests-changetaskstatusrequest` |  |
| `app/Http/Requests/LoginRequest.php` | `??` | feat: add login request validation | `feat/app-http-requests-loginrequest` |  |
| `app/Http/Requests/RegisterRequest.php` | `??` | feat: add register request validation | `feat/app-http-requests-registerrequest` |  |
| `app/Http/Requests/StoreCommentRequest.php` | `??` | feat: add store comment request validation | `feat/app-http-requests-storecommentrequest` |  |
| `app/Http/Requests/StoreProjectRequest.php` | `??` | feat: add store project request validation | `feat/app-http-requests-storeprojectrequest` |  |
| `app/Http/Requests/StoreTaskRequest.php` | `??` | feat: add store task request validation | `feat/app-http-requests-storetaskrequest` |  |
| `app/Http/Requests/UpdateProjectRequest.php` | `??` | feat: add update project request validation | `feat/app-http-requests-updateprojectrequest` |  |
| `app/Http/Requests/UpdateTaskRequest.php` | `??` | feat: add update task request validation | `feat/app-http-requests-updatetaskrequest` |  |
| `app/Http/Resources/CommentResource.php` | `??` | feat: add comment API resource | `feat/app-http-resources-commentresource` |  |
| `app/Http/Resources/ProjectResource.php` | `??` | feat: add project API resource | `feat/app-http-resources-projectresource` |  |
| `app/Http/Resources/TaskResource.php` | `??` | feat: add task API resource | `feat/app-http-resources-taskresource` |  |
| `app/Notifications/TaskAssignedNotification.php` | `??` | feat: add task assigned notification | `feat/app-notifications-taskassignednotification` |  |
| `app/Policies/ProjectPolicy.php` | `??` | feat: add project policy | `feat/app-policies-projectpolicy` |  |
| `app/Policies/TaskPolicy.php` | `??` | feat: add task policy | `feat/app-policies-taskpolicy` |  |
| `app/Providers/Filament/AdminPanelProvider.php` | `??` | feat: add Filament admin panel provider | `feat/app-providers-filament-adminpanelprovider` |  |
| `app/Services/AuthService.php` | `??` | feat: add auth service | `feat/app-services-authservice` |  |
| `app/Services/CommentService.php` | `??` | feat: add comment service | `feat/app-services-commentservice` |  |
| `app/Services/ProjectService.php` | `??` | feat: add project service | `feat/app-services-projectservice` |  |
| `app/Services/TaskService.php` | `??` | feat: add task service | `feat/app-services-taskservice` |  |
| `composer.lock` | `??` | build: lock PHP dependency versions | `build/add-composer-lock` |  |
| `database/migrations/2026_03_07_210428_create_personal_access_tokens_table.php` | `??` | feat: add migration to create personal access tokens table | `feat/database-migrations-2026-03-07-210428-create-personal-access-tokens-table` |  |
| `database/migrations/2026_03_08_145707_drop_activity_logs_table.php` | `??` | feat: add migration to drop activity logs table | `feat/database-migrations-2026-03-08-145707-drop-activity-logs-table` |  |
| `database/migrations/2026_03_08_145838_create_activity_log_table.php` | `??` | feat: add migration to create activity log table | `feat/database-migrations-2026-03-08-145838-create-activity-log-table` |  |
| `database/migrations/2026_03_08_145839_add_event_column_to_activity_log_table.php` | `??` | feat: add migration to add event column to activity log table | `feat/database-migrations-2026-03-08-145839-add-event-column-to-activity-log-table` |  |
| `database/migrations/2026_03_08_145840_add_batch_uuid_column_to_activity_log_table.php` | `??` | feat: add migration to add batch uuid column to activity log table | `feat/database-migrations-2026-03-08-145840-add-batch-uuid-column-to-activity-log-table` |  |
| `database/migrations/2026_03_08_150609_drop_notifications_table.php` | `??` | feat: add migration to drop notifications table | `feat/database-migrations-2026-03-08-150609-drop-notifications-table` |  |
| `database/migrations/2026_03_08_151102_create_notifications_table.php` | `??` | feat: add migration to create notifications table | `feat/database-migrations-2026-03-08-151102-create-notifications-table` |  |
| `database/migrations/2026_03_08_151717_add_action_column_to_activity_log_table.php` | `??` | feat: add migration to add action column to activity log table | `feat/database-migrations-2026-03-08-151717-add-action-column-to-activity-log-table` |  |
| `database/migrations/2026_03_08_203801_add_soft_deletes_to_tables.php` | `??` | feat: add migration to add soft deletes to tables | `feat/database-migrations-2026-03-08-203801-add-soft-deletes-to-tables` |  |
| `public/.DS_Store` | `??` | chore: remove macOS Finder metadata from public | `chore/ignore-public-ds-store` | Usually should be deleted or ignored instead of committed. |
| `public/css/filament/filament/app.css` | `??` | build: add app stylesheet asset | `build/public-css-filament-filament-app` | Generated/public asset. |
| `public/fonts/filament/filament/inter/index.css` | `??` | build: add index font asset | `build/public-fonts-filament-filament-inter-index` | Generated/public asset. |
| `public/fonts/filament/filament/inter/inter-cyrillic-ext-wght-normal-IYF56FF6.woff2` | `??` | build: add inter cyrillic ext wght normal iyf56 ff6 font asset | `build/public-fonts-filament-filament-inter-inter-cyrillic-ext-wght-normal-iyf56ff6` | Generated/public asset. |
| `public/fonts/filament/filament/inter/inter-cyrillic-wght-normal-JEOLYBOO.woff2` | `??` | build: add inter cyrillic wght normal jeolyboo font asset | `build/public-fonts-filament-filament-inter-inter-cyrillic-wght-normal-jeolyboo` | Generated/public asset. |
| `public/fonts/filament/filament/inter/inter-greek-ext-wght-normal-EOVOK2B5.woff2` | `??` | build: add inter greek ext wght normal eovok2 b5 font asset | `build/public-fonts-filament-filament-inter-inter-greek-ext-wght-normal-eovok2b5` | Generated/public asset. |
| `public/fonts/filament/filament/inter/inter-greek-wght-normal-IRE366VL.woff2` | `??` | build: add inter greek wght normal ire366 vl font asset | `build/public-fonts-filament-filament-inter-inter-greek-wght-normal-ire366vl` | Generated/public asset. |
| `public/fonts/filament/filament/inter/inter-latin-ext-wght-normal-HA22NDSG.woff2` | `??` | build: add inter latin ext wght normal ha22 ndsg font asset | `build/public-fonts-filament-filament-inter-inter-latin-ext-wght-normal-ha22ndsg` | Generated/public asset. |
| `public/fonts/filament/filament/inter/inter-latin-wght-normal-NRMW37G5.woff2` | `??` | build: add inter latin wght normal nrmw37 g5 font asset | `build/public-fonts-filament-filament-inter-inter-latin-wght-normal-nrmw37g5` | Generated/public asset. |
| `public/fonts/filament/filament/inter/inter-vietnamese-wght-normal-CE5GGD3W.woff2` | `??` | build: add inter vietnamese wght normal ce5 ggd3 w font asset | `build/public-fonts-filament-filament-inter-inter-vietnamese-wght-normal-ce5ggd3w` | Generated/public asset. |
| `public/images/consulting.png` | `??` | feat: add consulting image asset | `feat/public-images-consulting` |  |
| `public/images/logo.png` | `??` | feat: add logo image asset | `feat/public-images-logo` |  |
| `public/js/filament/actions/actions.js` | `??` | build: add actions javascript asset | `build/public-js-filament-actions-actions` | Generated/public asset. |
| `public/js/filament/filament/app.js` | `??` | build: add app javascript asset | `build/public-js-filament-filament-app` | Generated/public asset. |
| `public/js/filament/filament/echo.js` | `??` | build: add echo javascript asset | `build/public-js-filament-filament-echo` | Generated/public asset. |
| `public/js/filament/forms/components/checkbox-list.js` | `??` | build: add checkbox list javascript asset | `build/public-js-filament-forms-components-checkbox-list` | Generated/public asset. |
| `public/js/filament/forms/components/code-editor.js` | `??` | build: add code editor javascript asset | `build/public-js-filament-forms-components-code-editor` | Generated/public asset. |
| `public/js/filament/forms/components/color-picker.js` | `??` | build: add color picker javascript asset | `build/public-js-filament-forms-components-color-picker` | Generated/public asset. |
| `public/js/filament/forms/components/date-time-picker.js` | `??` | build: add date time picker javascript asset | `build/public-js-filament-forms-components-date-time-picker` | Generated/public asset. |
| `public/js/filament/forms/components/file-upload.js` | `??` | build: add file upload javascript asset | `build/public-js-filament-forms-components-file-upload` | Generated/public asset. |
| `public/js/filament/forms/components/key-value.js` | `??` | build: add key value javascript asset | `build/public-js-filament-forms-components-key-value` | Generated/public asset. |
| `public/js/filament/forms/components/markdown-editor.js` | `??` | build: add markdown editor javascript asset | `build/public-js-filament-forms-components-markdown-editor` | Generated/public asset. |
| `public/js/filament/forms/components/rich-editor.js` | `??` | build: add rich editor javascript asset | `build/public-js-filament-forms-components-rich-editor` | Generated/public asset. |
| `public/js/filament/forms/components/select.js` | `??` | build: add select javascript asset | `build/public-js-filament-forms-components-select` | Generated/public asset. |
| `public/js/filament/forms/components/slider.js` | `??` | build: add slider javascript asset | `build/public-js-filament-forms-components-slider` | Generated/public asset. |
| `public/js/filament/forms/components/tags-input.js` | `??` | build: add tags input javascript asset | `build/public-js-filament-forms-components-tags-input` | Generated/public asset. |
| `public/js/filament/forms/components/textarea.js` | `??` | build: add textarea javascript asset | `build/public-js-filament-forms-components-textarea` | Generated/public asset. |
| `public/js/filament/notifications/notifications.js` | `??` | build: add notifications javascript asset | `build/public-js-filament-notifications-notifications` | Generated/public asset. |
| `public/js/filament/schemas/components/actions.js` | `??` | build: add actions javascript asset | `build/public-js-filament-schemas-components-actions` | Generated/public asset. |
| `public/js/filament/schemas/components/tabs.js` | `??` | build: add tabs javascript asset | `build/public-js-filament-schemas-components-tabs` | Generated/public asset. |
| `public/js/filament/schemas/components/wizard.js` | `??` | build: add wizard javascript asset | `build/public-js-filament-schemas-components-wizard` | Generated/public asset. |
| `public/js/filament/schemas/schemas.js` | `??` | build: add schemas javascript asset | `build/public-js-filament-schemas-schemas` | Generated/public asset. |
| `public/js/filament/support/support.js` | `??` | build: add support javascript asset | `build/public-js-filament-support-support` | Generated/public asset. |
| `public/js/filament/tables/components/columns/checkbox.js` | `??` | build: add checkbox javascript asset | `build/public-js-filament-tables-components-columns-checkbox` | Generated/public asset. |
| `public/js/filament/tables/components/columns/select.js` | `??` | build: add select javascript asset | `build/public-js-filament-tables-components-columns-select` | Generated/public asset. |
| `public/js/filament/tables/components/columns/text-input.js` | `??` | build: add text input javascript asset | `build/public-js-filament-tables-components-columns-text-input` | Generated/public asset. |
| `public/js/filament/tables/components/columns/toggle.js` | `??` | build: add toggle javascript asset | `build/public-js-filament-tables-components-columns-toggle` | Generated/public asset. |
| `public/js/filament/tables/tables.js` | `??` | build: add tables javascript asset | `build/public-js-filament-tables-tables` | Generated/public asset. |
| `public/js/filament/widgets/components/chart.js` | `??` | build: add chart javascript asset | `build/public-js-filament-widgets-components-chart` | Generated/public asset. |
| `public/js/filament/widgets/components/stats-overview/stat/chart.js` | `??` | build: add chart javascript asset | `build/public-js-filament-widgets-components-stats-overview-stat-chart` | Generated/public asset. |
| `resources/.DS_Store` | `??` | chore: remove macOS Finder metadata from resources | `chore/ignore-resources-ds-store` | Usually should be deleted or ignored instead of committed. |
| `resources/css/app.css` | `??` | feat: add app stylesheet | `feat/resources-css-app` |  |
| `resources/css/filament/admin/theme.css` | `??` | feat: add theme stylesheet | `feat/resources-css-filament-admin-theme` |  |
| `resources/js/app.js` | `??` | feat: add app frontend script | `feat/resources-js-app` |  |
| `resources/views/components/action-message.blade.php` | `??` | feat: add action message Blade view | `feat/resources-views-components-action-message` |  |
| `resources/views/components/app-logo-icon.blade.php` | `??` | feat: add app logo icon Blade view | `feat/resources-views-components-app-logo-icon` |  |
| `resources/views/components/app-logo.blade.php` | `??` | feat: add app logo Blade view | `feat/resources-views-components-app-logo` |  |
| `resources/views/components/auth-header.blade.php` | `??` | feat: add auth header Blade view | `feat/resources-views-components-auth-header` |  |
| `resources/views/components/auth-session-status.blade.php` | `??` | feat: add auth session status Blade view | `feat/resources-views-components-auth-session-status` |  |
| `resources/views/components/desktop-user-menu.blade.php` | `??` | feat: add desktop user menu Blade view | `feat/resources-views-components-desktop-user-menu` |  |
| `resources/views/components/placeholder-pattern.blade.php` | `??` | feat: add placeholder pattern Blade view | `feat/resources-views-components-placeholder-pattern` |  |
| `resources/views/dashboard.blade.php` | `??` | feat: add dashboard Blade view | `feat/resources-views-dashboard` |  |
| `resources/views/filament/brand.blade.php` | `??` | feat: add brand Blade view | `feat/resources-views-filament-brand` |  |
| `resources/views/flux/icon/book-open-text.blade.php` | `??` | feat: add book open text Blade view | `feat/resources-views-flux-icon-book-open-text` |  |
| `resources/views/flux/icon/chevrons-up-down.blade.php` | `??` | feat: add chevrons up down Blade view | `feat/resources-views-flux-icon-chevrons-up-down` |  |
| `resources/views/flux/icon/folder-git-2.blade.php` | `??` | feat: add folder git 2 Blade view | `feat/resources-views-flux-icon-folder-git-2` |  |
| `resources/views/flux/icon/layout-grid.blade.php` | `??` | feat: add layout grid Blade view | `feat/resources-views-flux-icon-layout-grid` |  |
| `resources/views/flux/navlist/group.blade.php` | `??` | feat: add group Blade view | `feat/resources-views-flux-navlist-group` |  |
| `resources/views/layouts/app.blade.php` | `??` | feat: add app Blade view | `feat/resources-views-layouts-app` |  |
| `resources/views/layouts/app/header.blade.php` | `??` | feat: add header Blade view | `feat/resources-views-layouts-app-header` |  |
| `resources/views/layouts/app/sidebar.blade.php` | `??` | feat: add sidebar Blade view | `feat/resources-views-layouts-app-sidebar` |  |
| `resources/views/layouts/auth.blade.php` | `??` | feat: add auth Blade view | `feat/resources-views-layouts-auth` |  |
| `resources/views/layouts/auth/card.blade.php` | `??` | feat: add card Blade view | `feat/resources-views-layouts-auth-card` |  |
| `resources/views/layouts/auth/simple.blade.php` | `??` | feat: add simple Blade view | `feat/resources-views-layouts-auth-simple` |  |
| `resources/views/layouts/auth/split.blade.php` | `??` | feat: add split Blade view | `feat/resources-views-layouts-auth-split` |  |
| `resources/views/pages/auth/confirm-password.blade.php` | `??` | feat: add confirm password Blade view | `feat/resources-views-pages-auth-confirm-password` |  |
| `resources/views/pages/auth/forgot-password.blade.php` | `??` | feat: add forgot password Blade view | `feat/resources-views-pages-auth-forgot-password` |  |
| `resources/views/pages/auth/login.blade.php` | `??` | feat: add login Blade view | `feat/resources-views-pages-auth-login` |  |
| `resources/views/pages/auth/register.blade.php` | `??` | feat: add register Blade view | `feat/resources-views-pages-auth-register` |  |
| `resources/views/pages/auth/reset-password.blade.php` | `??` | feat: add reset password Blade view | `feat/resources-views-pages-auth-reset-password` |  |
| `resources/views/pages/auth/two-factor-challenge.blade.php` | `??` | feat: add two factor challenge Blade view | `feat/resources-views-pages-auth-two-factor-challenge` |  |
| `resources/views/pages/auth/verify-email.blade.php` | `??` | feat: add verify email Blade view | `feat/resources-views-pages-auth-verify-email` |  |
| `resources/views/pages/settings/layout.blade.php` | `??` | feat: add layout Blade view | `feat/resources-views-pages-settings-layout` |  |
| `resources/views/pages/settings/two-factor/⚡recovery-codes.blade.php` | `??` | feat: add ⚡recovery codes Blade view | `feat/resources-views-pages-settings-two-factor-recovery-codes` |  |
| `resources/views/pages/settings/⚡appearance.blade.php` | `??` | feat: add ⚡appearance Blade view | `feat/resources-views-pages-settings-appearance` |  |
| `resources/views/pages/settings/⚡delete-user-form.blade.php` | `??` | feat: add ⚡delete user form Blade view | `feat/resources-views-pages-settings-delete-user-form` |  |
| `resources/views/pages/settings/⚡delete-user-modal.blade.php` | `??` | feat: add ⚡delete user modal Blade view | `feat/resources-views-pages-settings-delete-user-modal` |  |
| `resources/views/pages/settings/⚡password.blade.php` | `??` | feat: add ⚡password Blade view | `feat/resources-views-pages-settings-password` |  |
| `resources/views/pages/settings/⚡profile.blade.php` | `??` | feat: add ⚡profile Blade view | `feat/resources-views-pages-settings-profile` |  |
| `resources/views/pages/settings/⚡two-factor-setup-modal.blade.php` | `??` | feat: add ⚡two factor setup modal Blade view | `feat/resources-views-pages-settings-two-factor-setup-modal` |  |
| `resources/views/pages/settings/⚡two-factor.blade.php` | `??` | feat: add ⚡two factor Blade view | `feat/resources-views-pages-settings-two-factor` |  |
| `resources/views/partials/head.blade.php` | `??` | feat: add head Blade view | `feat/resources-views-partials-head` |  |
| `resources/views/partials/settings-heading.blade.php` | `??` | feat: add settings heading Blade view | `feat/resources-views-partials-settings-heading` |  |
| `resources/views/projects/create.blade.php` | `??` | feat: add create Blade view | `feat/resources-views-projects-create` |  |
| `resources/views/projects/edit.blade.php` | `??` | feat: add edit Blade view | `feat/resources-views-projects-edit` |  |
| `resources/views/projects/index.blade.php` | `??` | feat: add index Blade view | `feat/resources-views-projects-index` |  |
| `resources/views/projects/partials/form.blade.php` | `??` | feat: add form Blade view | `feat/resources-views-projects-partials-form` |  |
| `resources/views/projects/show.blade.php` | `??` | feat: add show Blade view | `feat/resources-views-projects-show` |  |
| `resources/views/tasks/create.blade.php` | `??` | feat: add create Blade view | `feat/resources-views-tasks-create` |  |
| `resources/views/tasks/edit.blade.php` | `??` | feat: add edit Blade view | `feat/resources-views-tasks-edit` |  |
| `resources/views/tasks/index.blade.php` | `??` | feat: add index Blade view | `feat/resources-views-tasks-index` |  |
| `resources/views/tasks/partials/form.blade.php` | `??` | feat: add form Blade view | `feat/resources-views-tasks-partials-form` |  |
| `resources/views/tasks/show.blade.php` | `??` | feat: add show Blade view | `feat/resources-views-tasks-show` |  |
| `resources/views/welcome.blade.php` | `??` | feat: add welcome Blade view | `feat/resources-views-welcome` |  |
| `routes/api.php` | `??` | feat: add API route definitions | `feat/add-api-routes` |  |
| `storage/app/.gitignore` | `??` | chore: add gitignore storage placeholder | `chore/storage-app` | Keep only placeholder files like .gitignore under storage. |
| `storage/app/private/.gitignore` | `??` | chore: add gitignore storage placeholder | `chore/storage-app-private` | Keep only placeholder files like .gitignore under storage. |
| `storage/app/public/.gitignore` | `??` | chore: add gitignore storage placeholder | `chore/storage-app-public` | Keep only placeholder files like .gitignore under storage. |
| `storage/framework/.gitignore` | `??` | chore: add gitignore storage placeholder | `chore/storage-framework` | Keep only placeholder files like .gitignore under storage. |
| `storage/framework/cache/.gitignore` | `??` | chore: add gitignore storage placeholder | `chore/storage-framework-cache` | Keep only placeholder files like .gitignore under storage. |
| `storage/framework/cache/data/.gitignore` | `??` | chore: add gitignore storage placeholder | `chore/storage-framework-cache-data` | Keep only placeholder files like .gitignore under storage. |
| `storage/framework/sessions/.gitignore` | `??` | chore: add gitignore storage placeholder | `chore/storage-framework-sessions` | Keep only placeholder files like .gitignore under storage. |
| `storage/framework/testing/.gitignore` | `??` | chore: add gitignore storage placeholder | `chore/storage-framework-testing` | Keep only placeholder files like .gitignore under storage. |
| `storage/framework/views/.gitignore` | `??` | chore: add gitignore storage placeholder | `chore/storage-framework-views` | Keep only placeholder files like .gitignore under storage. |
| `storage/logs/.gitignore` | `??` | chore: add gitignore storage placeholder | `chore/storage-logs` | Keep only placeholder files like .gitignore under storage. |
| `tests/Feature/Api/AuthControllerTest.php` | `??` | test: add auth controller test feature test | `test/tests-feature-api-authcontrollertest` |  |
| `tests/Feature/Api/ResourceRoutesTest.php` | `??` | test: add resource routes test feature test | `test/tests-feature-api-resourceroutestest` |  |
| `tests/Feature/Auth/AuthenticationTest.php` | `??` | test: add authentication test feature test | `test/tests-feature-auth-authenticationtest` |  |
| `tests/Feature/Auth/EmailVerificationTest.php` | `??` | test: add email verification test feature test | `test/tests-feature-auth-emailverificationtest` |  |
| `tests/Feature/Auth/PasswordConfirmationTest.php` | `??` | test: add password confirmation test feature test | `test/tests-feature-auth-passwordconfirmationtest` |  |
| `tests/Feature/Auth/PasswordResetTest.php` | `??` | test: add password reset test feature test | `test/tests-feature-auth-passwordresettest` |  |
| `tests/Feature/Auth/RegistrationTest.php` | `??` | test: add registration test feature test | `test/tests-feature-auth-registrationtest` |  |
| `tests/Feature/Auth/TwoFactorChallengeTest.php` | `??` | test: add two factor challenge test feature test | `test/tests-feature-auth-twofactorchallengetest` |  |
| `tests/Feature/DashboardTest.php` | `??` | test: add dashboard test feature test | `test/tests-feature-dashboardtest` |  |
| `tests/Feature/ExampleTest.php` | `??` | test: add example test feature test | `test/tests-feature-exampletest` |  |
| `tests/Feature/Filament/ActivityAndNotificationResourcesTest.php` | `??` | test: add activity and notification resources test feature test | `test/tests-feature-filament-activityandnotificationresourcestest` |  |
| `tests/Feature/Filament/CommentResourceVisibilityTest.php` | `??` | test: add comment resource visibility test feature test | `test/tests-feature-filament-commentresourcevisibilitytest` |  |
| `tests/Feature/Filament/ProjectStatsOverviewWidgetTest.php` | `??` | test: add project stats overview widget test feature test | `test/tests-feature-filament-projectstatsoverviewwidgettest` |  |
| `tests/Feature/Filament/TaskStatusActionTest.php` | `??` | test: add task status action test feature test | `test/tests-feature-filament-taskstatusactiontest` |  |
| `tests/Feature/RoleMiddlewareTest.php` | `??` | test: add role middleware test feature test | `test/tests-feature-rolemiddlewaretest` |  |
| `tests/Feature/Settings/PasswordUpdateTest.php` | `??` | test: add password update test feature test | `test/tests-feature-settings-passwordupdatetest` |  |
| `tests/Feature/Settings/ProfileUpdateTest.php` | `??` | test: add profile update test feature test | `test/tests-feature-settings-profileupdatetest` |  |
| `tests/Feature/Settings/TwoFactorAuthenticationTest.php` | `??` | test: add two factor authentication test feature test | `test/tests-feature-settings-twofactorauthenticationtest` |  |
| `tests/Feature/Web/ProjectPagesTest.php` | `??` | test: add project pages test feature test | `test/tests-feature-web-projectpagestest` |  |
| `tests/Feature/Web/TaskPagesTest.php` | `??` | test: add task pages test feature test | `test/tests-feature-web-taskpagestest` |  |
| `tests/Pest.php` | `??` | test: add pest test setup | `test/tests-pest` |  |
| `tests/TestCase.php` | `??` | test: add test case test setup | `test/tests-testcase` |  |
| `tests/Unit/ExampleTest.php` | `??` | test: add example test unit test | `test/tests-unit-exampletest` |  |
| `tests/Unit/FilamentResourceConfigTest.php` | `??` | test: add filament resource config test unit test | `test/tests-unit-filamentresourceconfigtest` |  |
| `tests/Unit/ProjectPolicyTest.php` | `??` | test: add project policy test unit test | `test/tests-unit-projectpolicytest` |  |
| `tests/Unit/TaskPolicyTest.php` | `??` | test: add task policy test unit test | `test/tests-unit-taskpolicytest` |  |
