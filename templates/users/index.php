<?php
$pageTitle = 'Utilisateurs';
$users     = getAllUsers();
?>
<?php include __DIR__ . '/../base/header.php'; ?>
<?php include __DIR__ . '/../base/navbar.php'; ?>

<main class="py-4">
<div class="container">

    <h2 class="mb-4">Utilisateurs</h2>

    <?php if (empty($users)): ?>
        <div class="alert alert-info">Aucun utilisateur trouvé.</div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nom d'utilisateur</th>
                    <th>Rôle</th>
                    <th>Créé le</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td>
                        <?php
                        $badgeClass = match ($user['role']) {
                            'admin'        => 'bg-danger',
                            'gestionnaire' => 'bg-warning text-dark',
                            default        => 'bg-secondary',
                        };
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($user['role']) ?></span>
                    </td>
                    <td><?= $user['created_at'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

