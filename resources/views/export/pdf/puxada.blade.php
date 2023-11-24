<!doctype html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$group_name}}</title>
    @vite('resources/scss/tail.scss')
</head>
<body>
<div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-12">
        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <h1>Puxada</h1>
                <h3 class="text-center">{{$group_name}} - {{now()->format('d/m/Y H:i')}}</h3>
                <table >
                    <thead class="bg-white border-b">
                    <tr>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Nome</th>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Telefone</th>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Celular</th>
                        <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Endereço</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr class="bg-gray-100 border-b" id="{{$item->id}}">
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{$item->name}}</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{$item?->telephone??null}}</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{$item?->cellphone??null}}</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                {{$item?->address?->full_address??null}}
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
