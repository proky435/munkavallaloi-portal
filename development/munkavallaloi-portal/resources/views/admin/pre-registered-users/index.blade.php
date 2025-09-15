<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Előregisztrált felhasználók kezelése') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-lg border border-gray-200/50 dark:border-gray-700/50">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Header Actions -->
                    <div class="mb-6 flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium">{{ __('CSV Import') }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Tömeges felhasználó importálás CSV fájlból') }}</p>
                        </div>
                        
                        <div class="flex gap-3">
                            <a href="{{ route('admin.pre-registered-users.template') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                {{ __('Sablon letöltése') }}
                            </a>
                        </div>
                    </div>

                    <!-- Import Form -->
                    <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                        <form method="POST" action="{{ route('admin.pre-registered-users.store') }}" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-4 items-end">
                            @csrf
                            <div class="flex-1">
                                <label for="csv_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('CSV fájl feltöltése') }}
                                </label>
                                <div class="flex items-center space-x-4">
                                    <input type="file" name="csv_file" accept=".csv" required
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    <button type="submit"
                                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                        {{ __('Import') }}
                                    </button>
                                    <button type="button" onclick="showHelpModal()"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        {{ __('Help') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if($preRegisteredUsers->count() > 0)
                        <!-- Users Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Név') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Email') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Munkahely') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Státusz') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Létrehozva') }}
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('Műveletek') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($preRegisteredUsers as $preUser)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                                                            {{ strtoupper(substr($preUser->name, 0, 2)) }}
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                            {{ $preUser->name }}
                                                        </div>
                                                        @if($preUser->phone)
                                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                                {{ $preUser->phone }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">{{ $preUser->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $preUser->workplace->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($preUser->is_registered)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                                        {{ __('Regisztrált') }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400">
                                                        {{ __('Várakozik') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $preUser->created_at->format('Y.m.d H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if(!$preUser->is_registered)
                                                    <button onclick="copyRegistrationLink('{{ $preUser->registration_token }}')" 
                                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                                                        {{ __('Link másolása') }}
                                                    </button>
                                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                                @endif
                                                <form method="POST" action="{{ route('admin.pre-registered-users.destroy', $preUser) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Biztosan törölni szeretné?')" 
                                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 ml-3">
                                                        {{ __('Törlés') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $preRegisteredUsers->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-500 dark:text-gray-400 text-lg">
                                {{ __('Nincs előregisztrált felhasználó.') }}
                            </div>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">
                                {{ __('Töltsön fel egy CSV fájlt a felhasználók importálásához.') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Help Modal -->
    <div id="helpModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('CSV Import Súgó') }}</h3>
                    <button onclick="hideHelpModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="text-sm text-gray-700 dark:text-gray-300 space-y-4">
                    <div>
                        <h4 class="font-semibold mb-2">{{ __('CSV formátum követelmények:') }}</h4>
                        <ul class="list-disc list-inside space-y-1 ml-4">
                            <li>{{ __('Elválasztó karakter: pontosvessző (;)') }}</li>
                            <li>{{ __('Dátum formátum: ÉÉÉÉ.HH.NN (pl. 1990.01.15)') }}</li>
                            <li>{{ __('Csak 5 oszlop szükséges') }}</li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold mb-2">{{ __('Kötelező mezők (sorrendben):') }}</h4>
                        <ol class="list-decimal list-inside space-y-1 ml-4">
                            <li>{{ __('Teljes név (name)') }}</li>
                            <li>{{ __('Adóazonosító (tax_number)') }}</li>
                            <li>{{ __('Születési dátum (birth_date): ÉÉÉÉ.HH.NN') }}</li>
                            <li>{{ __('Bankszámlaszám (bank_account_number)') }}</li>
                            <li>{{ __('Munkahely név (workplace_name): Brema, Boden, vagy Tarragona') }}</li>
                        </ol>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold mb-2">{{ __('Példa CSV sor:') }}</h4>
                        <code class="block bg-gray-100 dark:bg-gray-700 p-2 rounded text-xs">
                            Kovács János;12345678901;1990.01.15;12345678-12345678-12345678;Brema
                        </code>
                    </div>
                    
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded">
                        <p class="text-blue-800 dark:text-blue-200 text-sm">
                            <strong>{{ __('Tipp:') }}</strong> {{ __('Töltsd le a sablont a "Sablon letöltése" gombbal, hogy biztosan jó formátumot használj!') }}
                        </p>
                    </div>
                </div>
                
                <div class="flex justify-end mt-6">
                    <button onclick="hideHelpModal()" 
                            class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        {{ __('Bezárás') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showHelpModal() {
            document.getElementById('helpModal').classList.remove('hidden');
        }
        
        function hideHelpModal() {
            document.getElementById('helpModal').classList.add('hidden');
        }
        
        // Close modal when clicking outside
        document.getElementById('helpModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideHelpModal();
            }
        });
    </script>

    <script>
        function copyRegistrationLink(token) {
            const url = `${window.location.origin}/register?token=${token}`;
            navigator.clipboard.writeText(url).then(function() {
                alert('Regisztrációs link másolva a vágólapra!');
            }, function(err) {
                console.error('Hiba a másolás során: ', err);
                // Fallback for older browsers
                const textArea = document.createElement("textarea");
                textArea.value = url;
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    alert('Regisztrációs link másolva a vágólapra!');
                } catch (err) {
                    alert('Hiba történt a másolás során');
                }
                document.body.removeChild(textArea);
            });
        }
    </script>
</x-app-layout>
