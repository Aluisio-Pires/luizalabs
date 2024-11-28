<script setup>
import {Head, Link} from "@inertiajs/vue3";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById("screenshot-container")?.classList.add("!hidden");
    document.getElementById("docs-card")?.classList.add("!row-span-1");
    document.getElementById("docs-card-content")?.classList.add("!flex-row");
    document.getElementById("background")?.classList.add("!hidden");
}
</script>

<template>
    <Head title="Welcome"/>
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/80">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl md:px-6 lg:max-w-7xl">
                <header
                    class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3"
                >
                    <div class="flex lg:justify-center lg:col-start-2">
                        <svg
                            class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20]"
                            viewBox="0 0 62 65"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M61.8548 14.6253C61.8778 14.7102 61.8895 14.7978 61.8897 14.8858V28.5615C61.8898 28.737 61.8434 28.9095 61.7554 29.0614C61.6675 29.2132 61.5409 29.3392 61.3887 29.4265L49.9104 36.0351V49.1337C49.9104 49.4902 49.7209 49.8192 49.4118 49.9987L25.4519 63.7916C25.3971 63.8227 25.3372 63.8427 25.2774 63.8639C25.255 63.8714 25.2338 63.8851 25.2101 63.8913C25.0426 63.9354 24.8666 63.9354 24.6991 63.8913C24.6716 63.8838 24.6467 63.8689 24.6205 63.8589C24.5657 63.8389 24.5084 63.8215 24.456 63.7916L0.501061 49.9987C0.348882 49.9113 0.222437 49.7853 0.134469 49.6334C0.0465019 49.4816 0.000120578 49.3092 0 49.1337L0 8.10652C0 8.01678 0.0124642 7.92953 0.0348998 7.84477C0.0423783 7.8161 0.0598282 7.78993 0.0697995 7.76126C0.0884958 7.70891 0.105946 7.65531 0.133367 7.6067C0.152063 7.5743 0.179485 7.54812 0.20192 7.51821C0.230588 7.47832 0.256763 7.43719 0.290416 7.40229C0.319084 7.37362 0.356476 7.35243 0.388883 7.32751C0.425029 7.29759 0.457436 7.26518 0.498568 7.2415L12.4779 0.345059C12.6296 0.257786 12.8015 0.211853 12.9765 0.211853C13.1515 0.211853 13.3234 0.257786 13.475 0.345059L25.4531 7.2415H25.4556C25.4955 7.26643 25.5292 7.29759 25.5653 7.32626C25.5977 7.35119 25.6339 7.37362 25.6625 7.40104C25.6974 7.43719 25.7224 7.47832 25.7523 7.51821C25.7735 7.54812 25.8021 7.5743 25.8196 7.6067C25.8483 7.65656 25.8645 7.70891 25.8844 7.76126C25.8944 7.78993 25.9118 7.8161 25.9193 7.84602C25.9423 7.93096 25.954 8.01853 25.9542 8.10652V33.7317L35.9355 27.9844V14.8846C35.9355 14.7973 35.948 14.7088 35.9704 14.6253C35.9792 14.5954 35.9954 14.5692 36.0053 14.5405C36.0253 14.4882 36.0427 14.4346 36.0702 14.386C36.0888 14.3536 36.1163 14.3274 36.1375 14.2975C36.1674 14.2576 36.1923 14.2165 36.2272 14.1816C36.2559 14.1529 36.292 14.1317 36.3244 14.1068C36.3618 14.0769 36.3942 14.0445 36.4341 14.0208L48.4147 7.12434C48.5663 7.03694 48.7383 6.99094 48.9133 6.99094C49.0883 6.99094 49.2602 7.03694 49.4118 7.12434L61.3899 14.0208C61.4323 14.0457 61.4647 14.0769 61.5021 14.1055C61.5333 14.1305 61.5694 14.1529 61.5981 14.1803C61.633 14.2165 61.6579 14.2576 61.6878 14.2975C61.7103 14.3274 61.7377 14.3536 61.7551 14.386C61.7838 14.4346 61.8 14.4882 61.8199 14.5405C61.8312 14.5692 61.8474 14.5954 61.8548 14.6253ZM59.893 27.9844V16.6121L55.7013 19.0252L49.9104 22.3593V33.7317L59.8942 27.9844H59.893ZM47.9149 48.5566V37.1768L42.2187 40.4299L25.953 49.7133V61.2003L47.9149 48.5566ZM1.99677 9.83281V48.5566L23.9562 61.199V49.7145L12.4841 43.2219L12.4804 43.2194L12.4754 43.2169C12.4368 43.1945 12.4044 43.1621 12.3682 43.1347C12.3371 43.1097 12.3009 43.0898 12.2735 43.0624L12.271 43.0586C12.2386 43.0275 12.2162 42.9888 12.1887 42.9539C12.1638 42.9203 12.1339 42.8916 12.114 42.8567L12.1127 42.853C12.0903 42.8156 12.0766 42.7707 12.0604 42.7283C12.0442 42.6909 12.023 42.656 12.013 42.6161C12.0005 42.5688 11.998 42.5177 11.9931 42.4691C11.9881 42.4317 11.9781 42.3943 11.9781 42.3569V15.5801L6.18848 12.2446L1.99677 9.83281ZM12.9777 2.36177L2.99764 8.10652L12.9752 13.8513L22.9541 8.10527L12.9752 2.36177H12.9777ZM18.1678 38.2138L23.9574 34.8809V9.83281L19.7657 12.2459L13.9749 15.5801V40.6281L18.1678 38.2138ZM48.9133 9.14105L38.9344 14.8858L48.9133 20.6305L58.8909 14.8846L48.9133 9.14105ZM47.9149 22.3593L42.124 19.0252L37.9323 16.6121V27.9844L43.7219 31.3174L47.9149 33.7317V22.3593ZM24.9533 47.987L39.59 39.631L46.9065 35.4555L36.9352 29.7145L25.4544 36.3242L14.9907 42.3482L24.9533 47.987Z"
                                fill="currentColor"
                            />
                        </svg>
                    </div>
                    <nav v-if="canLogin" class="flex flex-1 justify-end">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('accounts.index')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Contas
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>
                <div
                    class="bg-white md:p-8 rounded-md bg-gradient-to-br from-white via-white to-blue-600/10"
                >
                    <div class="container mx-auto p-6">
                        <header class="mb-10">
                            <h1 class="text-4xl font-bold text-blue-600">
                                Conta Corrente - Luizalabs
                            </h1>
                            <h2 class="text-xl text-gray-700 mt-2">
                                Desafio Técnico para Desenvolvedor Laravel
                                (Backend)
                            </h2>
                            <h3 class="text-lg text-gray-700 mt-2">
                                Código disponível em
                                <a
                                    href="https://github.com/Aluisio-Pires/luizalabs"
                                    class="text-blue-600 hover:underline"
                                >https://github.com/Aluisio-Pires/luizalabs</a
                                >
                            </h3>
                        </header>

                        <section class="mb-8">
                            <h3
                                class="text-2xl font-semibold text-gray-800 mb-4"
                            >
                                Resumo do Desafio
                            </h3>
                            <p class="text-gray-700 leading-relaxed">
                                O projeto consiste no desenvolvimento de um
                                sistema robusto e confiável para a gestão de
                                contas correntes de um banco, com
                                funcionalidades que abrangem desde o registro e
                                controle de dados de contas até o processamento
                                de transações financeiras. Cada conta deve ser
                                devidamente estruturada com atributos
                                essenciais, como número único, saldo atual, data
                                de criação e um histórico detalhado de
                                transações, que incluirá depósitos, saques e
                                transferências. Adicionalmente, o sistema
                                precisa implementar regras de negócio claras,
                                como o respeito a limites de crédito, aplicação
                                automática de taxas em operações financeiras, e
                                garantia de consistência em transferências, que
                                devem ser realizadas de forma atômica para
                                evitar inconsistências entre contas de origem e
                                destino.
                            </p>
                            <p class="text-gray-700 leading-relaxed">
                                Para assegurar a confiabilidade e a
                                escalabilidade, o sistema deve ser projetado
                                para lidar com múltiplas transações simultâneas
                                em uma mesma conta, utilizando mecanismos de
                                sincronização ou bloqueio para evitar conflitos
                                de concorrência. Além disso, será essencial o
                                registro detalhado de todas as transações e
                                mudanças no saldo, permitindo auditorias
                                futuras. O desenvolvimento incluirá também um
                                método para processamento em lote de transações,
                                garantindo que qualquer falha seja devidamente
                                registrada e revertida sem prejuízo à
                                integridade dos dados. Como um desafio
                                adicional, espera-se uma estratégia para
                                recuperação de falhas durante o processamento de
                                transações, de modo a garantir a continuidade do
                                sistema sem perda de dados. O projeto deve ser
                                entregue com código-fonte funcional, acompanhado
                                de testes unitários e de integração que
                                assegurem o cumprimento dos requisitos.
                            </p>
                        </section>

                        <section class="mb-8">
                            <h3
                                class="text-2xl font-semibold text-gray-800 mb-4"
                            >
                                Considerações Gerais
                            </h3>
                            <ul
                                class="list-disc pl-6 text-gray-700 leading-relaxed space-y-2"
                            >
                                <li>
                                    Cada conta possui um saldo geral e um limite
                                    de crédito fixo. Esse saldo geral pode ser
                                    negativo contanto que a soma do saldo com o
                                    limite de crédito seja maior ou igual a
                                    zero.
                                </li>
                                <li>
                                    O projeto utiliza um padrão de armazenamento
                                    de valores em Microns (feito através de
                                    casting) para salvar os valores decimais
                                    como inteiros no banco. Salvar os valores
                                    como Microns (6 casas decimais) evita
                                    problemas de arredondamento e cálculo com
                                    valores decimais, além de garantir que taxas
                                    de baixa percentagem tenham efeito sobre os
                                    valores.
                                </li>
                                <li>
                                    Foi utilizado o Laravel Jetstream para
                                    agilizar o desenvolvimento da autenticação e
                                    criação de telas no frontend.
                                </li>
                                <li>
                                    Foi utilizado o Laravel Reverb para
                                    implementar o Websockets responsáveis por
                                    notificar os clientes, em tempo real, sobre
                                    o andamento das transações.
                                </li>
                                <li>
                                    A garantia de idempotência foi adicionada
                                    aos FormRequests de criação (o método put já
                                    é idempotente) por meio de um cache de 15
                                    segundos que verifica se esses mesmos dados
                                    já foram passados anteriormente.
                                </li>
                                <li>
                                    Foi utilizado um sistema de ledger,
                                    sub-ledger e transações para garantir a
                                    integridade dos dados e manter registros de
                                    falhas sem alterar os valores das contas.
                                </li>
                                <li>
                                    Ao criar uma transação, é disparado um job
                                    para a fila do Redis. Esse job faz o lock de
                                    outros jobs para as contas relacionadas a
                                    essas transações, garantindo que transações
                                    paralelas não afetem a integridade da
                                    transação processada.
                                </li>
                                <li>
                                    Ao processar uma transação, é utilizado
                                    <code>DB::transaction</code> para garantir
                                    que todas as alterações no banco sejam
                                    feitas, ou retornem ao estado anterior. No
                                    caso de falha, a transação recebe um status
                                    de falha e não gera alterações nas contas
                                    envolvidas.
                                </li>
                                <li>
                                    Caso a transação ocorra normalmente, é
                                    criado um subledger para registrar os dados
                                    da transação. Esse subledger é relacionado à
                                    transação principal e ao ledger principal
                                    que é responsável por registrar se o valor
                                    representa uma entrada ou uma saída
                                    financeira àquela conta.
                                </li>
                                <li>
                                    Em transações do tipo transferência, são
                                    registrados dois subledgers, um para a conta
                                    de origem e outro para a conta de destino.
                                </li>
                                <li>
                                    O sistema de transações funciona em lote,
                                    permitindo que as transações sejam
                                    processadas simultaneamente e que os dados
                                    de cada transação sejam registrados em um
                                    subledger separado.
                                </li>
                                <li>
                                    A auditoria e log é feito por um modelo
                                    chamado Trail que é criado em Observers nos
                                    modelos de conta e transação.
                                </li>
                                <li>
                                    O sistema de permissões não foi
                                    implementado, pois não fazia parte do escopo
                                    solicitado no desafio. Porém, as policies
                                    foram geradas e estão prontas para receberem
                                    o sistema de permissões.
                                </li>
                                <li>
                                    A cobertura de código foi feita em cima da
                                    pasta <code>app/Http</code> e consta 100% de
                                    cobertura de testes.
                                </li>
                                <li>
                                    A documentação da API foi feita usando uma
                                    biblioteca própria que transforma a
                                    estrutura do Laravel em uma estrutura do
                                    Swagger.
                                </li>
                                <li>
                                    O projeto foi criado usando Laravel Sail
                                    para garantir que os ambientes de
                                    desenvolvimento e de testes sejam
                                    compatíveis, evitando problemas de
                                    compatibilidade entre sistemas operacionais
                                    e versões de PHP.
                                </li>
                            </ul>
                        </section>

                        <section class="mb-8">
                            <h3
                                class="text-2xl font-semibold text-gray-800 mb-4"
                            >
                                Tecnologias Utilizadas
                            </h3>
                            <ul
                                class="grid grid-cols-2 md:grid-cols-3 gap-4 text-gray-700"
                            >
                                <li>
                                    <a
                                        href="https://laravel.com/"
                                        class="text-blue-600 hover:underline"
                                    >Laravel</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://vuejs.org/"
                                        class="text-blue-600 hover:underline"
                                    >Vue.js</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://inertiajs.com/"
                                        class="text-blue-600 hover:underline"
                                    >Inertia.js</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://jetstream.laravel.com/"
                                        class="text-blue-600 hover:underline"
                                    >Laravel Jetstream</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://tailwindcss.com/"
                                        class="text-blue-600 hover:underline"
                                    >Tailwind CSS</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://www.postgresql.org/"
                                        class="text-blue-600 hover:underline"
                                    >PostgreSQL</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://redis.io/"
                                        class="text-blue-600 hover:underline"
                                    >Redis</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://reverb.laravel.com/"
                                        class="text-blue-600 hover:underline"
                                    >Laravel Reverb</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://laravel.com/docs/sail"
                                        class="text-blue-600 hover:underline"
                                    >Laravel Sail</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://pestphp.com/"
                                        class="text-blue-600 hover:underline"
                                    >Pest</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://laravel.com/docs/pint"
                                        class="text-blue-600 hover:underline"
                                    >Laravel Pint</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://larastan.org/"
                                        class="text-blue-600 hover:underline"
                                    >Larastan</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://github.com/rectorphp/rector"
                                        class="text-blue-600 hover:underline"
                                    >Rector</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://swagger.io/"
                                        class="text-blue-600 hover:underline"
                                    >Swagger</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://www.docker.com/"
                                        class="text-blue-600 hover:underline"
                                    >Docker</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://getcomposer.org/"
                                        class="text-blue-600 hover:underline"
                                    >Composer</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://nodejs.org/"
                                        class="text-blue-600 hover:underline"
                                    >Node.js & NPM</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://git-scm.com/"
                                        class="text-blue-600 hover:underline"
                                    >Git</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://github.com/"
                                        class="text-blue-600 hover:underline"
                                    >GitHub</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://docs.microsoft.com/pt-br/windows/wsl/"
                                        class="text-blue-600 hover:underline"
                                    >WSL</a
                                    >
                                </li>
                            </ul>
                        </section>

                        <section class="mb-8">
                            <h3
                                class="text-2xl font-semibold text-gray-800 mb-4"
                            >
                                Pré-requisitos
                            </h3>
                            <ul
                                class="list-disc pl-6 text-gray-700 leading-relaxed"
                            >
                                <li>
                                    <a
                                        href="https://docs.docker.com/get-docker/"
                                        class="text-blue-600 hover:underline"
                                    >Docker</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://getcomposer.org/download/"
                                        class="text-blue-600 hover:underline"
                                    >Composer</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://nodejs.org/en/download/"
                                        class="text-blue-600 hover:underline"
                                    >Node.js e NPM</a
                                    >
                                </li>
                            </ul>
                        </section>

                        <section class="mb-8">
                            <h3
                                class="text-2xl font-semibold text-gray-800 mb-4"
                            >
                                Instalação
                            </h3>
                            <ol
                                class="list-decimal pl-6 text-gray-700 leading-relaxed space-y-2"
                            >
                                <li>Clone o repositório:</li>
                                <pre
                                    class="bg-gray-100 p-4 rounded-md text-sm text-wrap"
                                ><code>git clone git@github.com:Aluisio-Pires/luizalabs.git && cd luizalabs</code></pre>
                                <li>
                                    Copie o arquivo
                                    <code>.env.example</code> para
                                    <code>.env</code>:
                                </li>
                                <pre
                                    class="bg-gray-100 p-4 rounded-md text-sm"
                                ><code>cp .env.example .env</code></pre>
                                <li>Instale as dependências do Composer:</li>
                                <pre
                                    class="bg-gray-100 p-4 rounded-md text-sm"
                                ><code>composer install</code></pre>
                                <li>Instale as dependências do NPM:</li>
                                <pre
                                    class="bg-gray-100 p-4 rounded-md text-sm"
                                ><code>npm install
npm run build</code></pre>
                                <li>Monte o ambiente de desenvolvimento:</li>
                                <pre
                                    class="bg-gray-100 p-4 rounded-md text-sm"
                                ><code>./vendor/bin/sail build
./vendor/bin/sail up -d</code></pre>
                                <li>
                                    Execute os comandos para gerar a key e o
                                    link com o storage:
                                </li>
                                <pre
                                    class="bg-gray-100 p-4 rounded-md text-sm"
                                ><code>./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan storage:link</code></pre>
                                <li>
                                    Execute o comando de migração do banco de
                                    dados:
                                </li>
                                <pre
                                    class="bg-gray-100 p-4 rounded-md text-sm"
                                ><code>./vendor/bin/sail artisan migrate</code></pre>
                                <li>Inicie o servidor de Websockets:</li>
                                <pre
                                    class="bg-gray-100 p-4 rounded-md text-sm text-wrap"
                                ><code>./vendor/bin/sail artisan reverb:start --debug</code></pre>
                                <li>
                                    Abra um novo terminal e inicie as filas com
                                    o Redis:
                                </li>
                                <pre
                                    class="bg-gray-100 p-4 rounded-md text-sm text-wrap"
                                ><code>./vendor/bin/sail artisan queue:listen redis</code></pre>
                                <li>
                                    O Swagger pode ser acessado em
                                    <a
                                        href="http://127.0.0.1:9000/documentation"
                                        class="text-blue-600 hover:underline"
                                    >http://127.0.0.1:9000/documentation</a
                                    >
                                </li>
                                <li>(Opcional) Crie um alias para o sail:</li>
                                <div class="md:pl-6">
                                    <p class="font-semibold">Para o Bash:</p>
                                    <pre
                                        class="bg-gray-100 p-4 rounded-md text-sm text-wrap"
                                    ><code>echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc &amp;&amp; source ~/.bashrc</code></pre>
                                    <p class="font-semibold mt-4">
                                        Para o Zsh:
                                    </p>
                                    <pre
                                        class="bg-gray-100 p-4 rounded-md text-sm text-wrap"
                                    ><code>echo "alias sail='./vendor/bin/sail'" >> ~/.zshrc &amp;&amp; source ~/.zshrc</code></pre>
                                </div>
                            </ol>
                        </section>

                        <section class="mb-8">
                            <h3
                                class="text-2xl font-semibold text-gray-800 mb-4"
                            >
                                Considerações Finais
                            </h3>
                            <ul
                                class="list-disc pl-6 text-gray-700 leading-relaxed space-y-2"
                            >
                                <li>
                                    Apesar de ser um teste focado no backend,
                                    foi possível por em prática o conhecimento
                                    em frontend em estruturas como Paginação
                                    Infinita e Websockets.
                                </li>
                                <li>
                                    Apesar de simples, o desafio técnico abrange
                                    um conhecimento denso do ecossistema
                                    Laravel, permitindo exibir e testar as
                                    habilidades necessárias para o
                                    desenvolvimento de uma API robusta.
                                </li>
                            </ul>
                        </section>

                        <section class="mb-8">
                            <h3
                                class="text-2xl font-semibold text-gray-800 mb-4"
                            >
                                Desafio Adicional
                            </h3>
                            <h4
                                class="text-xl font-semibold text-gray-700 mb-2"
                            >
                                Recuperação de Falhas
                            </h4>
                            <p class="text-gray-700 leading-relaxed">
                                A contenção de falhas foi bem abordada durante o
                                desenvolvimento do projeto. O processamento por
                                filas dando um feedback visual ao usuário
                                permite que o mesmo consiga lidar em caso de
                                falhas inesperadas. Além disso, todas as
                                movimentações são registradas em log, o que
                                facilita a atuação em cima de eventuais erros
                                que possam atrapalhar o bom funcionamento do
                                sistema. Vale lembrar, que caso alguma transação
                                essencial falhe, ocorre rollback nos registros
                                afetados, não causando transtorno financeiro ao
                                usuário. Essa abordagem permite que o próprio
                                usuário consiga tentar realizar a transação
                                novamente e lidar com o problema.
                            </p>
                        </section>

                        <footer class="mt-10 border-t pt-6">
                            <p class="text-center text-gray-600">
                                Desenvolvido por Aluísio Pires para o desafio
                                técnico da Luizalabs.
                            </p>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
