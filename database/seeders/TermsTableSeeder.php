<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use LaraCar\Term;

class TermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('terms')->insert(
            [
                'description' => 1,
                'model_type' => '<p><strong>Acesso ao site</strong></p>
<p>Para acessar o conteúdo de site, pode ser solicitado ao usuário algumas informações pessoais como nome, e-mail e outros. Se acharmos que as informações não são corretas ou verdadeiras, temos o direito de recusar e/ou cancelar o acesso a qualquer tempo, sem notificação prévia.</p>
<p><strong>Restrições ao uso</strong></p>
<p>Você só poderá usar este site propósitos permitidos por nós. Você não poderá usá-lo em qualquer outro objetivo, especialmente comercial, sem o nosso consentimento prévio. Não associe nossas marcas a nenhuma outra. Não exponha nosso nome, logotipo, logomarca entre outros, indevidamente e de forma a causar confusão.</p>
<p><strong>Propriedade da informação</strong></p>
<p>O conteúdo do site não pode ser copiado, distribuído, publicado, carregado, postado ou transmitido por qualquer outro meio sem o nosso consentimento prévio, a não ser que a finalidade seja apenas a divulgação.</p>
<p><strong>Comentários</strong></p>
<p>Ao postar algum comentário ou depoimento em nosso site você autoriza o Mega Feirão Veículos a publicação do mesmo em qualquer lugar que desejarmos, a fim de cooperar com a divulgação de nossos produtos.</p>
<p><strong>Aviso legal</strong></p>
<p>A informação obtida ao usar este site não é completa e não cobre todas as questões, tópicos ou fatos que possam ser relevantes para seus objetivos. O uso deste site é de sua total responsabilidade. O conteúdo é oferecido como está e sem garantias de qualquer tipo, expressas ou implícitas. O conteúdo deste site não é palavra final sobre qualquer assunto, e podemos fazer melhorias a qualquer momento.</p>
<p>Você, e não o Mega Feirão Veículos, assume o custo de qualquer serviço, reparo ou correção necessários no caso de qualquer perda ou dano consequente do uso deste site ou seu conteúdo.</p>
<p>Você entende que nossa empresa não pode e não garante que arquivos disponíveis para download da Internet estejam livres de vírus, worms, cavalos de Tróia ou outro código que possa manifestar propriedades contaminadoras ou destrutivas.</p>
<p><strong>Limitação de responsabilidade</strong></p>
<p>A empresa Mega Feirão Veículos, provedores de serviço, provedores de conteúdo, empregados, agentes, administradores e diretores não serão responsáveis por qualquer dano eventual, direto, indireto, punitivo, real, consequente, especial, exemplar ou de qualquer outro tipo, incluindo perda de receita ou renda, dor e sofrimento, estresse emocional ou similares mesmo que a empresa tenha aconselhado sobre a possibilidade de tais danos.</p>
<p><strong>Indenização</strong></p>
<p>Você vai indenizar e isentar a Empresa, suas filiais, afiliados, licenciantes, provedores de serviço, provedores de conteúdo, empregados, agentes, administradores e diretores (referidas agora como Partes Isentas) de qualquer violação desse Termo de Uso aceito por você, incluindo o uso do Conteúdo diferente do expresso aqui. Você concorda que as Partes Isentas não têm responsabilidade ou conexão com qualquer violação ou uso não autorizado, e você concorda em remediar toda e qualquer perda, dano, julgamento, prêmios, custo, despesas e honorários advogatícios das Partes Isentas ligadas a violação. Você também indenizará e isentará as Partes Isentas de qualquer reivindicação de terceiros resultante do uso da informação contida neste site.</p>
<p><strong>Marcas registradas</strong></p>
<p>Marcas e logos presentes neste site são propriedade da Mega Feirão Veículos ou da parte que as disponibilizaram para a empresa. A empresa e as partes que disponibilizaram marca e logo detém todos os direitos sobre as mesmas.</p>
<p><strong>Informação provida pelo usuário</strong></p>
<p>Você não pode publicar enviar, apresentar ou fazer conexão a esse site com qualquer material que:</p>
<p>Você não tenha o direito de postar, incluindo material de propriedade de terceiros, defenda atividade ilegal ou discutir a intenção de fazer algo ilegal; seja vulgar, obsceno, pornográfico ou indecente ou que não diga respeito diretamente a este site; possa ameaçar ou insultar outros, difamar, caluniar, invadir a privacidade, perseguir, ser obsceno, pornográfico, racista, assediar ou ofender; busca explorar ou prejudicar crianças expondo-as a conteúdo inapropriado, perguntar sobre informações pessoais ou qualquer outro do tipo; infrinja qualquer propriedade intelectual ou outro direito de pessoa ou entidade, incluindo violações de direitos autorais, marca registrada ou direitos de publicidade; violam qualquer lei ou podem ser considerados para violar a lei; personifique ou deturpar sua conexão com qualquer entidade ou pessoa; ou ainda manipula títulos ou identificadores para encobrir a origem do conteúdo; promova qualquer empreendimento comercial (ex: oferecer produtos ou serviços em promoção) ou que engaje de qualquer forma em uma atividade comercial (ex: realizar sorteios ou concursos, expor banners patrocinadores e/ou solicitar bens e serviços) exceto que especificamente autorizado neste site; solicitar fundos, divulgações ou patrocinadores; incluir programas com vírus, worms e/ou Cavalos de Tróia ou qualquer outro código, arquivo ou programa de computador destinado a interromper, destruir ou limitar a funcionalidade de qualquer software ou hardware de computador ou telecomunicações; interrompa o fluxo normal da conversa, faça com que a tela “role” mais rápido que os os outros usuários conseguem acompanhar ou mesmo agir de modo a afetar a habilidade de outras pessoas de se engajar em atividades em tempo real neste site; inclua arquivos em formato MP3; desobedeça qualquer política ou regra estabelecida de tempos em tempos para o uso desse site ou qualquer rede conectada a ele; ou contenha hiperlinks para sites que contenham conteúdo que se enquadrem nas descrições acima.</p>
<p>Mesmo sem a obrigação de fazê-lo, nossa Empresa reserva o direito de monitorar o uso deste site para determinar o cumprimento desse Termo de Uso assim como o de remover ou vetar qualquer informação por qualquer razão. De qualquer forma você é completamente responsável pelo conteúdo de seus envios. Você sabe e concorda que nem a Empresa ou qualquer terceiro provendo conteúdo para a Empresa assumirá qualquer responsabilidade por nenhuma ação ou inação da Empresa ou referido terceiro a respeito de qualquer envio.</p>
<p><strong>Mídia</strong></p>
<p>Se você envia imagens para o site, evite enviar as que contenham dados de localização incorporados (EXIF GPS). Visitantes podem baixar estas imagens do site e extrair delas seus dados de localização.</p>
<p><strong>Cookies</strong></p>
<p>Ao deixar um comentário no site, você poderá optar por salvar seu nome, e-mail e site nos cookies. Isso visa seu conforto, assim você não precisará preencher seus dados novamente quando fizer outro comentário. Estes cookies duram um ano.</p>
<p>Se você tem uma conta e acessa este site, um cookie temporário será criado para determinar se seu navegador aceita cookies. Ele não contém nenhum dado pessoal e será descartado quando você fechar seu navegador.</p>
<p>Se você editar ou publicar um anúncio, um cookie adicional será salvo no seu navegador. Este cookie não inclui nenhum dado pessoal e simplesmente indica apenas os dados referente ao anúncio que você acabou de editar. Ele expira depois de 1 dia.</p>
<p><strong>Mídia incorporada de outros sites</strong></p>
<p>Artigos neste site podem incluir conteúdo incorporado como, por exemplo, vídeos, imagens, artigos, etc. Conteúdos incorporados de outros sites se comportam exatamente da mesma forma como se o visitante estivesse visitando o outro site.</p>
<p>Estes sites podem coletar dados sobre você, usar cookies, incorporar rastreamento adicional de terceiros e monitorar sua interação com este conteúdo incorporado, incluindo sua interação com o conteúdo incorporado se você tem uma conta e está conectado com o site.</p>
<p><strong>Por quanto tempo mantemos os seus dados?</strong></p>
<p>Para usuários que se registram no nosso site (se houver), também guardamos as informações pessoais que fornecem no seu perfil de usuário. Os administradores de sites também podem ver e editar estas informações.</p>
<p><strong>Quais os seus direitos sobre seus dados?</strong></p>
<p>Se você tiver uma conta neste site ou se tiver deixado comentários, pode solicitar um arquivo exportado dos dados pessoais que mantemos sobre você, inclusive quaisquer dados que nos tenha fornecido. Também pode solicitar que removamos qualquer dado pessoal que mantemos sobre você. Isto não inclui nenhuns dados que somos obrigados a manter para propósitos administrativos, legais ou de segurança.</p>
<p><strong>Segurança</strong></p>
<p>Toda senha usada para este site é somente para uso individual. Você é responsável pela segurança de sua senha (se for o caso). A Empresa tem o direito de monitorar a segurança de sua senha e ao seu critério pode pedir que você a mude. Se você usar qualquer senha que a Empresa considere insegura, ou ainda compartilhar seu acesso. A Empresa tem o direito de requisitar que a senha seja modificada e/ou cancelar a sua conta.</p>
<p>É proibido usar qualquer serviço ou ferramenta conectada a este site para comprometer a segurança ou mexer com os recursos do sistema e/ou contas. O uso ou distribuição de ferramentas destinadas para comprometer a segurança (ex: programas para descobrir senha, ferramentas de crack ou de sondagem da rede) são estritamente proibidos. Se você estiver envolvido em qualquer violação da segurança do sistema, a Empresa se reserva o direito de fornecer suas informações para os administradores de sistema de outros sites para ajudá-los a resolver incidentes de segurança. A Empresa se reserva o direito de investigar potenciais violações a esse Termo de Uso.</p>
<p>A Empresa se reserva o direito de cooperar totalmente com as autoridades competentes ou pedidos da justiça para que a Empresa revele a identidade de qualquer pessoa que publique e-mail, mensagem ou disponibilize qualquer material que possa violar esse Termo de Uso.</p>'
            ],
        );
    }
}
