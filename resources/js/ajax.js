import route from 'ziggy-js';
import {Ziggy} from './ziggy';

window.helpers = {
    checkPersonAndGroup: function (personId, groupId) {
        axios.post(route('ajax.checkPersonToGroup', undefined, undefined, Ziggy), {
            personId,
            groupId
        }).then(function (response) {
            console.log(response.data);
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
            console.log(response.data);
            flasher.success('Relatório solicitado com sucesso!');
        }).catch(function (error) {

            if (error.response.status === 429){
                flasher.error('Muitas solicitações, tente novamente mais tarde!');
            }else{
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
                    document.getElementById('state').value = r.data?.uf;
                    document.getElementById('complement').value = r.data?.complemento;
                });
        }
    },
    unCheckPersonAndGroup: function (personId, groupId) {
        axios.post(route('ajax.unCheckPersonToGroup', undefined, undefined, Ziggy), {
            personId,
            groupId
        }).then(function (response) {
            console.log(response.data);
            flasher.success('Desmarcado com sucesso!');
        }).catch(function (error) {
            console.log(error);
            flasher.error('Erro ao desmarcar!');
        });
    }
};
