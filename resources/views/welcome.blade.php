<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
        <script src="https://cdn.tailwindcss.com"></script>

        <script>
            const sleep = (time) => new Promise((resolve) => setTimeout(resolve, time));
            const fetchProgress = async () => {
                document.getElementById('jobProgress').innerText = '更新中…';
                document.getElementById('jobProgressPercent').innerText = '';
                await sleep(400); // 更新してるよ！ってわかるようにちょっと待つ
                await fetch('/api/progress')
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (!data.totalJobCount) {
                            document.getElementById('jobProgress').innerText = 'Jobがありません';
                            return;
                        }
                        document.getElementById('jobProgress').innerText = data.totalJobCount - (data.waitingJobCount + data.wipJobCount) + ' / ' + data.totalJobCount;
                        document.getElementById('jobProgressPercent').innerText = (data.totalJobCount - (data.waitingJobCount + data.wipJobCount)) / data.totalJobCount * 100 + ' %';
                    }).catch(error => {
                        console.error('Error:', error);
                        document.getElementById('jobProgress').innerText = 'エラー';
                });
            }
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const enqueue = async () => {
                await fetch('/api/enqueue', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                }).finally(() => {
                    fetchProgress();
                });
            }
            const reset = async () => {
                await fetch('/api/reset', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                }).finally(() => {
                    fetchProgress();
                });
            }
            window.onload = function () {
                fetchProgress()
                document.getElementById('get-progress').addEventListener('click', fetchProgress);
                document.getElementById('enqueue').addEventListener('click', enqueue);
                document.getElementById('reset').addEventListener('click', reset);
            }
        </script>
    </head>
    <body>
        <main class="m-6">
            <div>
                <a href="{{route('horizon.index')}}" class="text-blue-500 underline-offset-auto	underline">
                    Horizonのページへ
                </a>
                <div class="flex flex-col gap-6">
                    <div>
                        <h2 class="text-xl">Jobの操作</h2>
                        <div class="flex flex-col gap-2">
                            <button id="enqueue" class="py-2 bg-blue-500 text-white rounded-full text-center w-96 flex justify-center">
                                <span class="material-symbols-outlined">send</span>
                                キューイング
                            </button>
                            <button id="reset" class="py-2 bg-blue-500 text-white rounded-full text-center w-96 flex justify-center">
                                <span class="material-symbols-outlined">delete</span>
                                リセット
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h2 class="text-xl">Jobの進行状況</h2>
                        <button id="get-progress" class="py-2 bg-blue-500 text-white rounded-full text-center w-96 flex justify-center">
                            <span class="material-symbols-outlined">refresh</span>
                            更新
                        </button>

                        <div class="flex flex-col gap-2">
                            <p id="jobProgress"></p>
                            <p id="jobProgressPercent"></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
