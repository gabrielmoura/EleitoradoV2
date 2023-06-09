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
            console.error(error);
            flasher.error('Erro ao solicitar relatório!');
        });
    }
};
