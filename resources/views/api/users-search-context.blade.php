<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <title>Busca de usuários</title>
</head>
<body>
    <main>
        <h1>Busca de usuários</h1>

        @if ($search === '')
            <p>Nenhum termo de busca foi informado.</p>
            <p>Use o parâmetro &quot;search&quot; para pesquisar usuários por nome ou e-mail.</p>
        @else
            <p>Termo pesquisado: {{ $search }}</p>
            <p>Resultados encontrados: {{ $users->count() }}</p>

            @forelse ($users as $user)
                <article>
                    <h2>{{ $user->name }}</h2>
                    <dl>
                        <dt>ID</dt>
                        <dd>{{ $user->id }}</dd>
                        <dt>Nome</dt>
                        <dd>{{ $user->name }}</dd>
                        <dt>E-mail</dt>
                        <dd>{{ $user->email }}</dd>
                    </dl>
                </article>
            @empty
                <p>Nenhum usuário foi encontrado para o termo informado.</p>
            @endforelse
        @endif

        <p>Contexto gerado em: {{ $generatedAt->toIso8601String() }}</p>
    </main>
</body>
</html>
