import route from 'ziggy-js';
import {Ziggy} from './ziggy';

window.helpers = {
    checkPersonAndGroup: function (personId, groupId) {
        axios.post(route('ajax.checkPersonToGroup', undefined, undefined, Ziggy), {
            personId,
            groupId
        }).then(function (response) {

            flasher.success('Checado com sucesso!');
        })
            .catch(function (error) {
                console.log(error);
                flasher.error('Erro ao Checar relatório!');
            });
    },
    requestReportGroup: function (group_name) {
        axios.post(route('ajax.requestReportGroup', undefined, undefined, Ziggy), {
            group_name,
            checked: true
        }).then(function (response) {

            flasher.success('Relatório solicitado com sucesso!');
        }).catch(function (error) {

            if (error.response.status === 429) {
                flasher.error('Muitas solicitações, tente novamente mais tarde!');
            } else {
                flasher.error('Erro ao solicitar relatório!');
            }
        });
    },
    getCep: function (cep) {
        if (cep.length === 8 || cep.length === 9) {
            axios.post(route('ajax.getCep', undefined, undefined, Ziggy), {cep: cep})
                .then(function (r) {
                    document.getElementById('street').value = r.data?.logradouro;
                    document.getElementById('district').value = r.data?.bairro;
                    document.getElementById('city').value = r.data?.localidade;
                    document.getElementById('complement').value = r.data?.complemento;
                    document.getElementById('uf').value = r.data?.uf;
                });
        }
    },
    unCheckPersonAndGroup: function (personId, groupId) {
        axios.post(route('ajax.unCheckPersonToGroup', undefined, undefined, Ziggy), {
            personId,
            groupId
        }).then(function (response) {

            flasher.success('Desmarcado com sucesso!');
        }).catch(function (error) {
            console.log(error);
            flasher.error('Erro ao desmarcar!');
        });
    },
    banUser: function (userId) {
        axios.post(route('ajax.banUser', undefined, undefined, Ziggy), {
            userId
        }).then(function (response) {
            flasher.success('Banido com sucesso!');
            setInterval(function () {
                location.reload();
            }, 500);
        }).catch(function (error) {
            console.log(error);
            flasher.error('Erro ao banir!');
        });
    },
    unBanUser: function (userId) {
        axios.post(route('ajax.unBanUser', undefined, undefined, Ziggy), {
            userId
        }).then(function (response) {
            flasher.success('Desbanido com sucesso!');
            setInterval(function () {
                location.reload();
            }, 500);
        }).catch(function (error) {
            console.log(error);
            flasher.error('Erro ao desbanir!');
        });
    },
    reqInviteTo: function (email, company_id, role) {
        axios.post(route('ajax.reqInviteTo', undefined, undefined, Ziggy), {
            email,
            company_id,
            role
        }).then(function (response) {
            flasher.success('Convite enviado com sucesso!');
            setInterval(function () {
                location.reload();
            }, 500);
        }).catch(function (error) {
            console.log(error);
            flasher.error('Erro ao enviar!');
        });
    },
    readAlert: function (alertId) {
        axios.post(route('ajax.alert.read', alertId, undefined, Ziggy), {
            alertId
        }).then(function (response) {
            flasher.success('Marcado como Lido!');
            location.reload();
        }).catch(function (error) {
            console.log(error);
            // flasher.error('Erro ao marcar!');
        })
    },
    readMessage: function (alertId) {
        axios.post(route('ajax.message.read', alertId, undefined, Ziggy), {
            alertId
        }).then(function (response) {
            flasher.success('Marcado como Lido!');
            location.reload();
        }).catch(function (error) {
            console.log(error);
            // flasher.error('Erro ao marcar!');
        })
    },
    reqTagEvent: function (event_id) {
        // Solicita gerar Tags(credenciais para cartas) para o evento.
        flasher.success('Solicitação enviada com sucesso!');
    },
    reqMailEvent: function (event_id) {
        // Solicita enviar emails para os participantes do evento.
        flasher.success('Solicitação enviada com sucesso!');
    }
};

function printData(id) {
    let divToPrint = document.getElementById(`${id}`);
    let newWin = window.open("");
    newWin.document.write(divToPrint.outerHTML);
    newWin.print();
    newWin.close();
}

window.printData = printData;
