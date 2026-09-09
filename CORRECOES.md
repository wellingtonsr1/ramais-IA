# CORREÇÕES APLICADAS — Sistema Ramais (2026-09-09)

Este documento resume as correções aplicadas a partir da auditoria técnica (somente as
marcadas como Prioridade 1 e 2, além de itens simples de manutenção). Cada item indica o
ID do problema na auditoria.

## 🔴 Prioridade 1 — Segurança

| ID | Correção aplicada | Onde |
|----|-------------------|------|
| P-01 | Credenciais removidas do código. `modelo/conecta-banco.php` agora usa `includes/config.php` (não versionado) ou variáveis de ambiente `DB_*`. Template em `includes/config.exemplo.php`. | `modelo/conecta-banco.php`, `includes/config.exemplo.php`, `.gitignore` |
| P-01b | `.htaccess` bloqueia acesso web a `backup-do-banco/`, `util/`, `includes/` e a arquivos `.sql/.gz/.lock/.txt/.md` e `config*.php`. | `.htaccess` |
| P-02 | Toda saída dinâmica passa por `e()` (`htmlspecialchars` UTF-8). PHP não é mais ecoado dentro de `onClick`. URLs nos links usam `urlencode()`. Hash de senha não é mais consultado pelas telas. | todas as telas em `visao/` |
| P-03 / P-04 | Telas admin sem proteção agora exigem login admin: `filtrar-usuario.php`, `filtrar-funcionario.php`, `exibir-pesquisa-funcionario.php`, `form-editar-funcionario.php`. Formulários de edição carregam dados do **banco por id**, não da URL. | `visao/` (arquivos citados) |
| P-05 | Todos os validadores de acesso terminam com `exit` (via `redirecionar()`). | `controle/validador-acesso*.php` |
| P-06 | Login corrigido: registro inexistente → retorna `null`; comparação exata de usuário + `password_verify`. Compatível com PHP 8. | `controle/controle-valida-login.php`, `modelo/buscar-login.php` |
| P-07 | CSRF em **todos** os formulários (token por sessão, `hash_equals`). | `includes/funcoes.php` + forms |
| P-08 | Exclusões de ramal/funcionário/usuário eram links GET; agora são **formulários POST** com token e confirmação (`confirmarExclusaoForm`). | views de listagem + `controle-deletar-*.php` |
| P-09 | `visao/login.php` não destrói mais a sessão ao ser aberta. | `visao/login.php` |
| P-15 | Sessão endurecida: cookie HttpOnly/SameSite/Secure(auto), `session_regenerate_id(true)` no login, expiração por inatividade de 30 min. | `includes/sessao.php` |
| P-16 | `backup-do-banco/backup.php` só roda via **CLI** ou para admin autenticado; credenciais vêm do config externo. | `backup-do-banco/backup.php` |
| P-30 | Nível do usuário é lido do **banco** por id antes de editar/excluir (não vem mais da URL/GET). | `controle-deletar-usuario.php`, `controle-editar-usuario.php` |

## 🟠 Prioridade 2 — Correções e robustez

| ID | Correção aplicada | Onde |
|----|-------------------|------|
| P-10 | Precedência corrigida com parênteses; último admin não pode ser excluído (leitura no banco). | `controle/controle-deletar-usuario.php` |
| P-11 | Fluxo pós-troca de senha: redirecionamento `login.php?senha=alterada` (sem `session_destroy` + SweetAlert em fila). | `controle/controle-atualizar-senha.php`, `visao/login.php` |
| P-12 | `$opcao` sempre definido; `reset` só é aceito com admin na sessão; trava de id próprio para `alt`. | `controle/controle-atualizar-senha.php` |
| P-13 | Filtros de usuário/funcionário movidos para o banco (LIKE prefix) — sem `preg_match` com input interpolado. | `visao/filtrar-usuario.php`, `visao/filtrar-funcionario.php` |
| P-14 | `$_GET['usuario']` fantasma removido; telas de edição/redefinição resolvem tudo por id no banco. | `form-redefinir-senha.php`, `form-editar-*.php` |
| P-18 | `$_SESSION['arrayUsuarios']` removido (era desfeito dentro do loop). Filtro é direto no banco. | `visao/filtrar-usuario.php` |
| P-19 | Todos os acessos a `$_GET/$_POST` protegidos (`post_str`, `requisicao_id`, `??`). Sem warnings em PHP 8. | todo o projeto |
| P-24 | `catch` não imprime mais exceções; tudo vai para `error_log` com mensagem genérica ao usuário. Conexão PDO com `ERRMODE_EXCEPTION`. | `modelo/*.php`, `conecta-banco.php` |
| P-25 | Validação de telefone no JS estava invertida — corrigida. | `js/funcoes.js` |
| P-26 | `sucessoDel()` chamado antes da exclusão — removido. | `js/funcoes.js` |
| P-28 | Senha exige mínimo de 8 caracteres (PHP e JS). `PASSWORD_BCRYPT` com cost padrão (10). | `funcoes-de-controle.php`, `js/funcoes.js` |
| P-39 | Regexes de nome/setor/responsável relaxadas (aceitam nomes reais). Campos não são mais apagados ao digitar. | `funcoes-de-controle.php`, `js/funcoes.js` |

## Outras melhorias

- P-20/P-21/P-22/P-37: HTML corrigido (`value` com aspas, `class` duplicado, typo `email"s`, `</legend>` faltante).
- P-27: CDN deduplicados (1 jQuery + 1 SweetAlert2 + mask).
- P-36: `$exibirBotoes` calculado uma única vez e usado de forma consistente.
- Colisão de funções `buscarUsuario()`/`buscarSetor...` eliminada (`buscar-usuario.php` e `buscar-setor-funcionario.php` viraram arquivos de compatibilidade).
- Mensagens de conexão/backup não vazam detalhes internos.
- FPDF: `utf8_decode` substituído por `mb_convert_encoding` com fallback; rodapé sem sobreposição.
- Exclusão de setor valida funcionários **por idSetor** (não mais por nome).
- Novo modelo: `contarFuncionariosPorSetor()`, `buscarFuncionariosPorSetor()`, `buscarUsuarioPorId()`, `buscarFuncionarioPorId()`, `formatarTelefone()`.

## ⚠️ Passos obrigatórios no deploy (a fazer manualmente)

1. **Trocar a senha do MySQL** (a senha antiga ficou exposta no histórico do Git) e criar o `includes/config.php` a partir de `includes/config.exemplo.php`.
2. Remover as credenciais do histórico do Git quando possível (ex.: `git filter-repo`) — recomendação externa a esta mudança.
3. Remover do servidor/pasta web: `backup-do-banco/backups/listagemDeRamais.sql` e dumps `.sql.gz` antigos.
4. Habilitar `AllowOverride All` do Apache para a pasta do projeto (para o `.htaccess` valer).
5. Rodar (opcional, recomendado) `doc/melhorias-banco.sql` para UNIQUE de setor e índice de nome — ver premissas no próprio arquivo.
6. **Testar**: login (inclusive usuário inexistente), primeiro acesso, CRUD de ramais/funcionários/usuários, exclusões (confirmação + POST), troca e redefinição de senha, PDF, backup via CLI.

## Observação

`php -l` não pôde ser executado neste ambiente (PHP não instalado). Todos os arquivos foram
revisados individualmente; recomenda-se rodar `php -l` em todos os `.php` e um smoke test
completo em ambiente de desenvolvimento antes de publicar.
