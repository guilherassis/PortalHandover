$(document).ready(function() {
        var max_fields          = 10;   //max de 15 inscricoes de cada vez
        var x = 1;
        $('#add_field').click (function(e) {
                e.preventDefault();     //prevenir novos clicks
                if (x < max_fields) {
                        $('#listas').append('\
                                        <tr class="remove' + x + '" style="border-bottom:1pt solid black;">\
                                        <td><input type="hidden" name="indice[]" hidden value="1"/>\
                                        <select name="frenteTrabalho[]" id="frenteTrabalho"><option value="0">Frente de Trabalho...</option>\
                                        <option value="1">AMBIENTE E RELEASE</option>\
                                        <option value="2">ARQUITETURA CORPORATIVA</option>\
                                        <option value="3">ARQUITETURA DE SERVICOS, INFORMACOES E INOVACAO</option>\
                                        <option value="4">ARQUITETURA DE SOLUCOES</option>\
                                        <option value="5">ARQUITETURA DIGITAL</option>\
                                        <option value="6">ATENDIMENTO E OPERACAO</option>\
                                        <option value="7">ATIVACAO, FALHAS E MEDIACAO</option>\
                                        <option value="8">AUTOMACAO DIGITAL</option>\
                                        <option value="9">BANCO DE DADOS</option>\
                                        <option value="10">BI E GESTAO EMPRESARIAL</option>\
                                        <option value="11">CANAIS INDIRETOS DIGITAIS</option>\
                                        <option value="12">CICLO DA RECEITA E MEDIACAO</option>\
                                        <option value="13">COE DIGITAL</option>\
                                        <option value="14">CRM CONVERGENTE</option>\
                                        <option value="15">CRM FIXA</option>\
                                        <option value="16">CRM FIXA E TV</option>\
                                        <option value="17">CRM MOVEL E RECARGAS</option>\
                                        <option value="18">DESENV E IMPLANTACAO DE SVAS</option>\
                                        <option value="19">DESENV SOLUCOES E PROJETOS OI INTERNET</option>\
                                        <option value="20">DESENVOLVIMENTO DE ALIANCAS</option>\
                                        <option value="21">DESENVOLVIMENTO DE STARTUPS</option>\
                                        <option value="22">DESENVOLVIMENTO DIGITAL</option>\
                                        <option value="23">DIGITAL DELIVERY</option>\
                                        <option value="24">DIGITAL INSIGHTS</option>\
                                        <option value="25">DIGITAL MIS</option>\
                                        <option value="26">DW</option>\
                                        <option value="27">E-CARE</option>\
                                        <option value="28">E-COMMERCE EMPRESARIAL</option>\
                                        <option value="29">ESCRITORIO DE PROJETOS DE SISTEMAS</option>\
                                        <option value="30">EXPERIENCIA DIGITAL DO CLIENTE</option>\
                                        <option value="31">FATURAMENTO CONVERGENTE, RA E FRAUDE</option>\
                                        <option value="32">FATURAMENTO FIXA, COBRANCA E REPASSE</option>\
                                        <option value="33">GARANTIA DA QUALIDADE</option>\
                                        <option value="34">GESTAO DA CAPACIDADE E ORCAMENTO</option>\
                                        <option value="35">GESTAO DE ATIVOS</option>\
                                        <option value="36">GESTAO DE NIVEL DE SERVICO</option>\
                                        <option value="37">GESTAO DO DESEMPENHO DIGITAL</option>\
                                        <option value="38">GESTAO EMPRESARIAL E TRIBUTARIO</option>\
                                        <option value="39">GESTAO INFORMACIONAL</option>\
                                        <option value="40">GOVERNANCA E PMO DIGITAL</option>\
                                        <option value="41">GOVERNANCA PROCESSOS E DESEMPENHO</option>\
                                        <option value="42">IMPLANTACAO DE SOLUCOES DIGITAIS</option>\
                                        <option value="43">INFRAESTRUTURA DE DATA CENTER</option>\
                                        <option value="44">INTEGRACAO E WEB</option>\
                                        <option value="45">INTEGRACAO, OM E SERVICOS</option>\
                                        <option value="46">INVENTARIO, GIS E WFM</option>\
                                        <option value="47">LABORATORIO DIGITAL</option>\
                                        <option value="48">MICROINFORMATICA E COLABORACAO</option>\
                                        <option value="49">MIDIA DE PERFORMANCE</option>\
                                        <option value="50">OI WIFI</option>\
                                        <option value="51">OPERACAO E-CARE</option>\
                                        <option value="52">OPERACAO E-COMMERCE</option>\
                                        <option value="53">OPERACOES DE DATA CENTER</option>\
                                        <option value="54">OSS E PROVISIONAMENTO</option>\
                                        <option value="55">PLANEJAMENTO DE CAPACIDADE E DEMANDAS</option>\
                                        <option value="56">PLANEJAMENTO TECNOLOGICO E SOLUCOES</option>\
                                        <option value="57">PLATAFORMAS e API`S DIGITAIS</option>\
                                        <option value="58">PRE-PAGO E DESEMPENHO</option>\
                                        <option value="59">PRODUTOS DIGITAIS</option>\
                                        <option value="60">PRODUTOS VAREJO E B2B</option>\
                                        <option value="61">PROJETO E IMPLANTACAO INFRA ESTRUTURANTE DE TI</option>\
                                        <option value="62">PROJETOS DIGITAIS OPERACOES</option>\
                                        <option value="63">PROJETOS E IMPLANTACAO DEMANDAS DE TI</option>\
                                        <option value="64">PROJETOS E-CARE</option>\
                                        <option value="65">PROJETOS E-COMMERCE</option>\
                                        <option value="66">PROSPECCAO E IMPLANTACAO NN E SVAS</option>\
                                        <option value="67">REDES IP</option>\
                                        <option value="68">RELACIONAMENTO B2B, ESTRATEGIA E AREAS DE APOIO</option>\
                                        <option value="69">RELACIONAMENTO FINANCAS</option>\
                                        <option value="70">RELACIONAMENTO OPERACOES E DRC</option>\
                                        <option value="71">RELACIONAMENTO VAREJO</option>\
                                        <option value="72">REPORTES E ANALYTICS</option>\
                                        <option value="73">SEGURANCA CIBERNETICA DIGITAL</option>\
                                        <option value="74">SEGURANCA DE ACESSO E COMPLIANCE</option>\
                                        <option value="75">SEGURANCA DE INTELIGENCIA DE REDE E MSS</option>\
                                        <option value="76">SEGURANCA DE SISTEMA</option>\
                                        <option value="77">SERVICOS FINANCEIROS MOVEIS E SEGUROS</option>\
                                        <option value="78">SISTEMAS OPERACIONAIS</option>\
                                        <option value="79">TESTES</option>\
                                        <option value="80">TRANSFORMACAO DE BSS</option>\
                                        <option value="81">TRANSICAO PARA PRODUCAO</option>\
                                        <option value="82">TV, CREDITO E COMISSIONAMENTO</option>\
                                        <option value="83">VENDAS</option>\
                                        </select>\
                                        </td>\
                                        <td>\
                                                <input type="checkbox" value="1" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais">&nbsp&nbsp Administração Centralizada<br>\
                                                <input type="checkbox" value="2" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Atendimento Nivel 1 / Healthcheck<br>\
                                                <input type="checkbox" value="3" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Auditoria<br>\
                                                <input type="checkbox" value="4" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp BKP Infraestrutura<br>\
                                                <input type="checkbox" value="5" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Cadastro<br>\
                                                <input type="checkbox" value="6" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Capacidade<br>\
                                                <input type="checkbox" value="7" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Conectividade<br>\
                                        </td>\
                                        <td>\
                                                <input type="checkbox" value="8" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Contrato<br>\
                                                <input type="checkbox" value="9" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Dashboard Negócio<br>\
                                                <input type="checkbox" value="10" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Dashboard Operacional<br>\
                                                <input type="checkbox" value="11" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Governança ITIL<br>\
                                                <input type="checkbox" value="12" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Monitoração Aplicacional<br>\
                                                <input type="checkbox" value="13" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Monitoração Exp. do cliente (Robô)<br>\
                                                <input type="checkbox" value="14" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp MOP/POP<br>\
                                        </td>\
                                        <td>\
                                                <input type="checkbox" value="15" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Operação assistida / 1ª. Execução / BSIM<br>\
                                                <input type="checkbox" value="16" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Passagem de conhecimento<br>\
                                                <input type="checkbox" value="17" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Política de Expurgo<br>\
                                                <input type="checkbox" value="18" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Release – CRQ<br>\
                                                <input type="checkbox" value="19" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Runbook<br>\
                                                <input type="checkbox" value="20" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Segurança<br>\
                                                <input type="checkbox" value="21" name="requisitosFuncionais['+ x +']" id="requisitosFuncionais" >&nbsp&nbsp Tecnologia<br>\
                                        </td>\
                                        <td><button href="#" class="remove_campo" id="remove' + x +'" >Remover Frente</button></td>\
                        ');
                        x++;
                }
        });
 
        //this is not the best move, because will create overhead...
        //but is for simplicity
        //damn users
        $('#listas').on("click",".remove_campo",function(e) {
                e.preventDefault();
                var tr = $(this).attr('id');
                //alert ('remove: ' + tr);
                $('#listas tr.'+ tr).remove();
                x--;
        });
 
});