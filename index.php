<?php
// Inicia a sessão para simular o layout limpo e moderno
session_start();

$tela = $_GET['tela'] ?? 'lista';

// Lista de livros clássicos temporária apenas para fins estéticos (sem banco de dados por agora)
$livros_estaticos = [
    ['id' => 1, 'titulo' => 'Memórias Póstumas de Brás Cubas', 'autor' => 'Machado de Assis', 'ano_publicacao' => 1881, 'quantidade' => 15],
    ['id' => 2, 'titulo' => 'Dom Casmurro', 'autor' => 'Machado de Assis', 'ano_publicacao' => 1899, 'quantidade' => 12],
    ['id' => 3, 'titulo' => 'O Cortiço', 'autor' => 'Aluísio Azevedo', 'ano_publicacao' => 1890, 'quantidade' => 10],
    ['id' => 4, 'titulo' => 'Vidas Secas', 'autor' => 'Graciliano Ramos', 'ano_publicacao' => 1938, 'quantidade' => 8],
    ['id' => 5, 'titulo' => 'Grande Sertão: Veredas', 'autor' => 'João Guimarães Rosa', 'ano_publicacao' => 1956, 'quantidade' => 6],
    ['id' => 6, 'titulo' => 'Quincas Borba', 'autor' => 'Machado de Assis', 'ano_publicacao' => 1891, 'quantidade' => 9]
];

// Filtro de pesquisa estético simples
$busca = trim($_GET['busca'] ?? '');
if (!empty($busca)) {
    $livros_estaticos = array_filter($livros_estaticos, function($l) use ($busca) {
        return stripos($l['titulo'], $busca) !== false || stripos($l['autor'], $busca) !== false;
    });
}

$titulo = match ($tela) {
    'login' => 'Entrar na Biblioteca',
    'cadastro' => 'Cadastrar Novo Livro',
    default => 'Acervo da Biblioteca'
};
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistema de Gestão de Biblioteca</title>

    <!-- Bootstrap 5 CDN & FontAwesome para um visual moderno e atualizado -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        /* Sidebar moderna em tom marrom clássico sofisticado */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #3E2723 0%, #1A0F0D 100%);
            color: #fff;
        }
        .sidebar a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.2s;
        }
        .sidebar a:hover, .sidebar .active {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        }
        .btn-primary {
            background-color: #4E342E;
            border-color: #4E342E;
        }
        .btn-primary:hover {
            background-color: #3E2723;
            border-color: #3E2723;
        }
        .navbar-top {
            background: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,.04);
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <i class="fas fa-book-reader fa-2x mb-2 text-warning"></i>
                        <h5 class="fw-bold tracking-wider text-white">BIBLIOTECA</h5>
                    </div>
                    <hr class="text-secondary">
                    <ul class="nav flex-column gap-2">
                        <li class="nav-item">
                            <a class="nav-link active d-flex align-items-center gap-2 p-2" href="index.php?tela=lista">
                                <i class="fas fa-book-open"></i> Acervo de Livros
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <!-- Top Navbar -->
                <div class="d-flex justify-content-between align-items-center navbar-top p-3 mb-4 rounded shadow-sm">
                    <h4 class="m-0 fw-bold text-dark"><?= htmlspecialchars($titulo) ?></h4>
                    <div>
                        <a href="index.php?tela=login" class="btn btn-primary px-4"><i class="fas fa-sign-in-alt me-1"></i> Entrar</a>
                    </div>
                </div>

                <!-- Conteúdo Dinâmico -->
                <?php if ($tela === 'lista'): ?>
                    <!-- LISTAGEM -->
                    <div class="card p-4">
                        <form method="GET" action="index.php" class="row g-3 mb-4">
                            <input type="hidden" name="tela" value="lista">
                            <div class="col-md-10">
                                <input type="text" name="busca" class="form-control" placeholder="Pesquisar por título ou autor..." value="<?= htmlspecialchars($busca) ?>">
                            </div>
                            <div class="col-md-2 d-flex gap-2">
                                <button class="btn btn-primary w-100" type="submit"><i class="fas fa-search"></i></button>
                                <a href="index.php" class="btn btn-outline-secondary"><i class="fas fa-undo"></i></a>
                            </div>
                        </form>

                        <div class="mb-3 text-end">
                            <a href="index.php?tela=cadastro" class="btn btn-success"><i class="fas fa-plus me-1"></i> Novo Livro</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Título do Livro</th>
                                        <th>Autor</th>
                                        <th>Ano</th>
                                        <th>Exemplares</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($livros_estaticos)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">Nenhum livro encontrado no acervo.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($livros_estaticos as $p): ?>
                                            <tr>
                                                <td class="fw-bold">#<?= $p['id'] ?></td>
                                                <td><?= htmlspecialchars($p['titulo']) ?></td>
                                                <td><?= htmlspecialchars($p['autor']) ?></td>
                                                <td><?= $p['ano_publicacao'] ?></td>
                                                <td><span class="badge bg-secondary"><?= $p['quantidade'] ?></span></td>
                                                <td class="text-center">
                                                    <a href="index.php?tela=cadastro" class="btn btn-sm btn-outline-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                                    <a href="#" class="btn btn-sm btn-outline-danger" onclick="alert('Funcionalidade de exclusão (será integrada com o banco depois)'); return false;" title="Excluir"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php elseif ($tela === 'cadastro'): ?>
                    <!-- FORMULÁRIO DE CADASTRO -->
                    <div class="card p-4 col-md-8 mx-auto shadow-sm">
                        <form action="index.php" method="GET">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Título do Livro</label>
                                <input type="text" name="titulo" class="form-control" placeholder="Ex: Memórias Póstumas de Brás Cubas" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Autor</label>
                                <input type="text" name="autor" class="form-control" placeholder="Ex: Machado de Assis" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Ano de Publicação</label>
                                <input type="number" name="ano_publicacao" class="form-control" placeholder="Ex: 1881" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Quantidade de Exemplares</label>
                                <input type="number" name="quantidade" class="form-control" placeholder="Ex: 15" required>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary" onclick="alert('Simulação estética salva com sucesso!'); window.location.href='index.php'; return false;"><i class="fas fa-save me-1"></i> Salvar Livro</button>
                            </div>
                        </form>
                    </div>

                <?php elseif ($tela === 'login'): ?>
                    <!-- LOGIN -->
                    <div class="row justify-content-center mt-5">
                        <div class="col-md-5">
                            <div class="card p-4 shadow">
                                <div class="text-center mb-4">
                                    <i class="fas fa-lock fa-2x text-primary mb-2"></i>
                                    <h4 class="fw-bold">Acesso Restrito</h4>
                                </div>
                                <form action="index.php" method="GET">
                                    <div class="mb-3">
                                        <label class="form-label">E-mail</label>
                                        <input type="email" name="email" class="form-control" value="admin@biblioteca.local" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Senha</label>
                                        <input type="password" name="senha" class="form-control" value="123456" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-2" onclick="alert('Login simulado com sucesso!'); window.location.href='index.php'; return false;">Entrar no Sistema</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>