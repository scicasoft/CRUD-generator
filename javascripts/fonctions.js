$(document).ready(function(){

    $("h4.lien").click(function(){
        var info = $(this).attr('info');
        if (info!='tout') {
            $("div.informations").slideUp("slow");
            $("#"+info).slideDown("slow");
        }
        else {
            $("div.informations").slideUp("slow");
            $("div.informations").slideDown("slow");
        }
    });

    $('a.delete').click(function(){
        if (confirm("VOULEZ VOUS BIEN SUPPRIMER CE PACKET ?")){
            var id = "#"+$(this).attr('iden');
            var chemin = $(this).attr('lien');
            $(id).fadeOut("slow",function(){
                $(id).slideUp("slow");
                $("#load").load("scripts/decoupage/supprimerpacket.php", {
                    fichier:chemin
                });
            });
        }
    });

    $('input.activation').click(function(){
        $('#left').slideUp("slow");
        if ($(this).attr("checked"))
            $('#parametre_auto').slideDown("slow");
        else
            $('#parametre_auto').slideUp("slow");
    });

    $('#prefixe_attribut_table').click(function(){
        if ($(this).attr("checked"))
            $('#prefixe_attribut').slideUp("slow");
        else
            $('#prefixe_attribut').slideDown("slow");
    });

    $('#se_connecter').click(function(){
        if ($('#server').val()=="") {
            alert("ENTREZ LE NOM SERVEUR");
            return false;
        }
        if ($('#username').val()=="") {
            alert("ENTREZ LE NOM D'UTILISATEUR");
            return false;
        }
        $('#infos_base').slideUp("slow");
        $('#infos_autres').slideDown("slow");
        var db_driver   = $('#driver').val();
        var db_host     = $('#server').val();
        var db_user     = $('#username').val();
        var db_userpass = $('#userpass').val();
        $('#base').load("scripts/decoupage/base_select.php",{
            d_driver:db_driver,
            d_host:db_host,
            d_user:db_user,
            d_userpass:db_userpass
        });

        return true;
    });

    $('#annuler').click(function(){
        $('#infos_base').slideDown("slow");
        $('#infos_autres').slideUp("slow");
        $('#left').slideUp("slow");
    });

    $('#valider').click(function(){
        var db_driver   = $('#driver').val();
        var db_host     = $('#server').val();
        var db_user     = $('#username').val();
        var db_userpass = $('#userpass').val();
        var db_basename = $('#nom_base').val();
        if ($('#auto').attr("checked")){
            if ($('#identifiant_tables').val()=="") {
                alert("ENTREZ L'IDENTIFIANT DES TABLES");
                return false;
            }
            if ($('#identifiant_externe').val()=="") {
                alert("ENTREZ L'IDENTIFIANT EXTERNE");
                return false;
            }
            $('#left').slideUp("slow",function(){
                var db_prefixe_table = $('#prefixe_table').val();
                var db_id_tables = $('#identifiant_tables').val();
                var db_id_externe = $('#identifiant_externe').val();
                var db_id_externe_position = (($('#position2').attr("checked")) ? 'debut' : 'fin');
                var option = '';
                if ($('#option1').attr("checked")){
                    option = $('#option1').val();
                }
                else if ($('#option2').attr("checked")){
                    option = $('#option2').val();
                }
                else if ($('#option3').attr("checked")){
                    option = $('#option3').val();
                }
                
                $('#left').load("scripts/generation/automatique.php",{
                    d_driver : db_driver,
                    d_host : db_host,
                    d_user : db_user,
                    d_userpass : db_userpass,
                    d_name : db_basename,
                    d_prefixe_table : db_prefixe_table,
                    d_id_tables : db_id_tables,
                    d_id_externe : db_id_externe,
                    d_id_externe_position : db_id_externe_position,
                    option : option
                },function(){
                    $('#left').slideDown("slow");
                });
            });
        }
        else{
            $('#left').load("scripts/decoupage/selections.php",null,function(){
                $('#left').slideDown("slow", function(){
                    var url = 'scripts/decoupage/liste_base.php';
                    $('#dbvalues').load(url,{
                        d_driver:db_driver,
                        d_host:db_host,
                        d_user:db_user,
                        d_userpass:db_userpass
                    }, function(){
                        $('#dbvalues').slideDown("slow");

                        $('#basename').change(function(){
                            afficher_tables();
                        });
                    
                    });
                });
            });
        }
        return true;
    });

    function afficher_tables(){
        $('#attributs_parametres').slideUp("slow");
        $('#atvalues').slideUp("slow");
        $('#parametres').slideUp("slow");
        var db_driver   = $('#driver').val();
        var db_host     = $('#server').val();
        var db_user     = $('#username').val();
        var db_userpass = $('#userpass').val();
        var db_name     = $('#basename').val();
        var url = 'scripts/decoupage/liste_table.php';
        $('#tvalues').slideUp("slow",function(){
            $('#tvalues').load(url,{
                d_driver:db_driver,
                d_host:db_host,
                d_user:db_user,
                d_userpass:db_userpass,
                d_name:db_name
            }, function(){
            
                $('#tvalues').slideDown("slow");
            
                $('#tablename').change(function(){
                    afficher_attributs();
                });

            });
        });
    }

    function afficher_attributs(){
        $('#generer').slideDown("slow");
        $('#generer').click(function(){
            $('#etatgeneration').val(1);
            $('#manuel').submit();
        });
        $('#attributs_parametres').slideDown("slow",function(){
            var db_driver   = $('#driver').val();
            var db_host     = $('#server').val();
            var db_user     = $('#username').val();
            var db_userpass = $('#userpass').val();
            var db_name     = $('#basename').val();
            var db_table    = $('#tablename').val();
            var url = 'scripts/decoupage/parametres.php';
            $('#parametres').load(url,{
                d_driver:db_driver,
                d_host:db_host,
                d_user:db_user,
                d_userpass:db_userpass,
                d_name:db_name,
                d_table:db_table
            });
            url = 'scripts/decoupage/liste_attribut.php';
            $('#atvalues').slideUp("slow",function(){
                $('#atvalues').load(url,{
                    d_driver:db_driver,
                    d_host:db_host,
                    d_user:db_user,
                    d_userpass:db_userpass,
                    d_name:db_name,
                    d_table:db_table
                }, function(){
                    $('#atvalues').slideDown("slow");
                    $('#attributs').change(function(){
                        afficher_parametres();
                    });
                });
            });
        });
    }

    function afficher_parametres(){
        $('div.params_att').slideUp("fast",function(){
            var db_attribut    = $('#attributs').val();
            $('#att_'+db_attribut).slideDown("slow", function(){
                $('input.est_relation').click(function(){
                    var att = $(this).attr("att");
                    if ($(this).attr("checked"))
                        $('#relations_'+att).slideDown("slow");
                    else
                        $('#relations_'+att).slideUp("slow");
                });
                $('select.table_relation').change(function(){
                    var db_driver   = $('#driver').val();
                    var db_host     = $('#server').val();
                    var db_user     = $('#username').val();
                    var db_userpass = $('#userpass').val();
                    var db_name     = $('#basename').val();
                    var db_table    = $(this).val();
                    var db_attr     = $('#attributs').val();
                    $("#rel_att_table_"+db_attr).load("scripts/decoupage/relations.php", {
                        d_driver:db_driver,
                        d_host:db_host,
                        d_user:db_user,
                        d_userpass:db_userpass,
                        d_name:db_name,
                        d_table:db_table,
                        prefixe:'attribut_',
                        d_attr:db_attr
                    });
                    $("#rel_aff_table_"+db_attr).load("scripts/decoupage/relations.php", {
                        d_driver:db_driver,
                        d_host:db_host,
                        d_user:db_user,
                        d_userpass:db_userpass,
                        d_name:db_name,
                        d_table:db_table,
                        prefixe:'attribut_afficher_',
                        d_attr:db_attr
                    });
                });
            });
        });
    }

    $('#manuel').submit(function(){
        return $('#etatgeneration').val()==1;
    });
    
});