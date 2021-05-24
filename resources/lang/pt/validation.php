<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'O campo :attribute deve ser aceito.',
    'active_url' => 'O campo :attribute não é um URL válido.',
    'after' => 'O campo :attribute deve ser uma data depois :date.',
    'after_or_equal' => 'O campo :attribute deve ser uma data após ou igual a :date.',
    'alpha' => 'O campo :attribute pode conter apenas letras.',
    'alpha_dash' => 'O campo :attribute Pode conter apenas letras, números, traços e sublinhados.',
    'alpha_num' => 'O campo :attribute pode conter apenas letras e números.',
    'array' => 'O campo campo :attribute deve ser uma matriz.',
    'before' => 'O campo campo :attribute deve ser uma data antes :date.',
    'before_or_equal' => 'O campo :attribute deve ser uma data antes ou igual a :date.',
    'between' => [
        'numeric' => 'O campo :attribute deve estar entre :min e :max.',
        'file' => 'O campo :attribute deve ter entre: min e: max kilobytes. ',
        'string' => 'O campo :attribute deve ter entre: min e: max caracteres. ',
        'array' => 'O campo :attribute deve ter entre: min e: max itens. ',
    ],
    'boolean' => 'O campo :attribute deve ser verdadeiro ou falso. ',
    'confirmed' => 'A confirmação de :attribute não é idêntica.',
    'date' => 'O campo :attribute não é uma data válida.',
    'date_equals' => 'O campo :attribute deve ser uma data igual a :date.',
    'date_format' => 'O campo :attribute não corresponde ao formato :format.',
    'different' => 'O campo :attribute e :other deve ser diferente.',
    'digits' => 'O campo :attribute deve ser :digits de dígitos. ',
    'digits_between' => 'O campo :attribute deve ser entre :min e :max dígitos. ',
    'dimensions' => 'O campo :attribute tem dimensões de imagem inválidas. ',
    'distinct' => 'O campo :attribute tem um valor duplicado. ',
    'email' => 'O email informado não é válido.',
    'exists' => 'O campo :attribute selecionado é inválido. ',
    'file' => 'O campo :attribute deve ser um arquivo. ',
    'filled' => 'O campo :attribute deve ter um valor. ',
    'gt' => [
        'numeric' => 'O campo :attribute deve ser maior que :value. ',
        'file' => 'O campo :attribute deve ser maior que :value kilobytes. ',
        'string' => 'O campo :attribute deve ter mais que :value caracteres. ',
        'array' => 'O campo :attribute deve ter mais que :value itens. '
    ],
    'gte' => [
        'numeric' => 'O campo :attribute deve ser maior ou igual :value. ',
        'file' => 'O campo :attribute deve ser maior ou igual a :value kilobytes. ',
        'string' => 'O campo :attribute deve ser maior ou igual :value caracteres. ',
        'array' => 'O campo :attribute deve ter :value itens ou mais.',
    ],
    'image' => 'O campo :attribute deve ser uma imagem. ',
    'in' => 'O campo :attribute selecionado é inválido. ',
    'in_array' => 'O campo :attribute campo não existe em :other.',
    'integer' => 'O campo :attribute deve ser um inteiro. ',
    'ip' => 'O campo :attribute deve ser um endereço IP válido.',
    'ipv4' => 'O campo :attribute deve ser um endereço IPv4 válido. ',
    'ipv6' => 'O campo :attribute deve ser um endereço IPv6 válido. ',
    'json' => 'O campo :attribute deve ser uma string JSON válida. ',
    'lt' => [
        'numeric' => 'O campo :attribute deve ser menor que :value. ',
        'file' => 'O campo :attribute deve ser menor que :value kilobytes. ',
        'string' => 'O campo :attribute deve ser menor que :value caracteres. ',
        'array' => 'O campo :attribute deve ter menos de :value itens. ',
    ],
    'lte' => [
        'numeric' => 'O campo :attribute deve ser menor ou igual :value.',
        'file' => 'O campo :attribute deve ser menor ou igual :value kilobytes.',
        'string' => 'O campo :attribute deve ser menor ou igual :value caracteres.',
        'array' => 'O campo :attribute não deve ter mais de :value itens.',
    ],
    'max' => [
        'numeric' => 'O campo :attribute pode não ser maior que :max.',
        'file' => 'O campo :attribute pode não ser maior que :max kilobytes.',
        'string' => 'O campo :attribute pode não ser maior que :max caracteres.',
        'array' => 'O campo :attribute pode não ter mais de :max itens.',
    ],
    'mimes' => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes' => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'min' => [
        'numeric' => 'O campo :attribute deve ser pelo menos :min.',
        'file' => 'O campo :attribute deve ser pelo menos :min kilobytes.',
        'string' => 'O campo :attribute deve ser pelo menos :min caracteres.',
        'array' => 'O campo :attribute deve ter pelo menos :min itens.',
    ],
    'not_in' => 'O campo :attribute selecionado é inválido.',
    'not_regex' => 'O formato do campo :attribute é inválido.',
    'numeric' => 'O campo :attribute deve ser um número.',
    'present' => 'O campo :attribute campo deve estar presente.',
    'regex' => 'O formato do campo :attribute é inválido.',
    'required' => 'O campo :attribute é obrigatório.',
    'required_if' => 'O campo :attribute é necessário quando :other é :value.',
    'required_unless' => 'O campo :attribute é necessário a menos que :other seja :values.',
    'required_with' => 'O campo :attribute é necessário quando :values exista',
    'required_with_all' => 'O campo :attribute é necessário quando :values exista.',
    'required_without' => 'O campo :attribute é necessário quando :values não exista.',
    'required_without_all' => 'O campo :attribute é necessário quando nenhum dos :values exista.',
    'same' => 'Os campos :attribute e :other deve ser iguais.',
    'size' => [
        'numeric' => 'O campo :attribute deve ser :size.',
        'file' => 'O campo :attribute deve ser :size kilobytes.',
        'string' => 'O campo :attribute deve ser :size caracteres.',
        'array' => 'O campo :attribute deve ter :size itens.',
    ],
    'starts_with' => 'O campo :attribute deve começar com: :values',
    'ends_with' => 'O campo :attribute deve terminar com: :values',
    'string' => 'O campo :attribute deve ser um texto.',
    'timezone' => 'O campo :attribute deve ser uma zona válida.',
    'unique' => 'O :attribute informado já está cadastrado.',
    'uploaded' => 'Falha ao enviar :attribute',
    'url' => 'O formato do campo :attribute é inválido.',
    'uuid' => 'O campo :attribute deve ser um UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'Nome',
        'email' => 'Email',
        'country_code' => 'Código do País',
        'phone_number' => 'Telefone',
        'photo' => 'Foto',
        'password' => 'Senha',
        'description' => 'Descrição',
        'company' => 'Empresa',
        'providerName' => 'Nome do Provedor',
        'providerType' => 'Tipo de Provedor',
        'acUrl' => 'URL da Conta do Active Campaign',
        'acToken' => 'Token da Conta do Active Campaign',
        'clientId' => 'Client Id do Hotmart',
        'clientSecret' => 'Client Secret do Hotmart',
        'basic' => 'Campo Basic do Hotmart',
        'projectName' => 'Nome do Projeto',
        'projectDescription' => 'Descrição do Projeto',
        'leadsGoal' => 'Meta de Leads',
        'whatsappGoal' => 'Meta de Grupos no WhatsApp',
        'telegramGoal' => 'Meta de Leads no Telegram',
        'revenueGoalMin' => 'Meta de Faturamento Mínimo',
        'revenueGoal' => 'Meta de Faturamento Ideal',
        'revenueGoalMax' => 'Meta de Faturamento Top',
        'from_date' => 'Data de Início',
        'cart_date' => 'Abertura de Carrinho',
        'to_date' => 'Data de Encerramento',
        'niche' => 'Nicho',
        'sub_niche' => 'Sub-nicho',
        'type' => 'Tipo de Lançamento',
        'instagram' => 'Perfil do Instagram',
        'facebook' => 'Fanpage do Facebook',
        'youtube' => 'Canal do Youtube',
        'avatar' => 'Descreva o seu Avatar',
        'transformation' => 'Qual a transformação do Produto',
        'strengths' => 'O que você fez e funcionou?',
        'weaknesses' => 'O que faria diferente?',
        'opportunities' => 'Que oportunidades você identifica?',
        'threats' => 'Que ameaças podem prejudicar?',
        'instagram_followers_before' => 'Seguidores no Início',
        'instagram_followers_after' => 'Seguidores no Final',
        'facebook_fans_before' => 'Fãs no Início',
        'facebook_fans_after' => 'Fãs no Final',
        'youtube_subscribers_before' => 'Inscritos no Início',
        'youtube_subscribers_after' => 'Inscritos no Final',
        'projectTimeline' => 'Timeline do Lançamento',
        'projectOpportunities' => 'Oportunidades do Mercado',
        'projectAvatarInfo' => 'Avatar: Dores e Sonhos',
        'projectCopy' => 'Copy do Lançamento',
        'projectEventName' => 'Nome do Evento',
        'projectPromises' => 'Promessas do Lançamento',
        'avatarObjections' => 'Objeções do Avatar',
        'avatarTrapsMyths' => 'Armadilhas e mitos do avatar',
        'projectDesign' => 'Linha Gráfica do Lançamento',
        'productQualities' => 'Qualidades do Produto',
        'productEfficiency' => 'O produto realmente resolve os problemas?',
        'productUnique' => 'O Produto tem um sistema único/diferenciado?',
        'productSteps' => 'Passo a Passo',
        'productWarranty' => 'Garantia?',
        'offer_Unique' => 'A oferta é realmente irresistível',
        'commonEnemy' => 'Inimigo em Comum',
        'productWho' => 'Para quem é o Programa',
        'productRequirements' => 'Requisitos Necessários',
        'nicheEvaluation' => 'Nota do Nicho',
        'productEvaluation' => 'Nota do Produto',
        'offerEvaluation' => 'Nota da Oferta',
        'projectStrategy' => 'Informações adicionais:',
        'productAggregates' => 'Agregados do Produto Principal',
        'offersDescription' => 'Ofertas do Lançamento',
        'projectStructure' => 'Estrutura técnica do lançamento',
        'projectLinks' => 'Todos os links do lançamento:',
        'projectDefinitions' => 'Definições do lançamento',
        'projectAdsCopy' => 'Textos dos anúncios do lançamento',
    ],

    'Dashboard' => 'Meu Dashboard',
    'All' => 'Todos',
    'Today' => 'Hoje',
    'Yesterday' => 'Ontem',
    'Last 7 Days' => 'Últimos 7 Dias',
    'Last 14 Days' => 'Últimos 14 Dias',
    'Last 30 Days' => 'Últimos 30 Dias',
    'Last 60 Days' => 'Últimos 60 Dias',
    'Last 90 Days' => 'Últimos 90 Dias',
    'Last 180 Days' => 'Últimos 180 Dias',
    'Last 365 Days' => 'Últimos 365 Dias',
    'subject' => 'PowerHub - Reset de Senha',
];
