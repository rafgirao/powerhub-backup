<?php

namespace App\Http\Livewire;


use App\Models\Link as Deeplink;
use App\Models\Project;
use App\Services\Helper;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\DataTable\WithCachedRows;
use Illuminate\Validation\Rule;

class Link extends Component
{
    use WithPagination, WithCachedRows;

    public $deeplinkId, $url, $project, $short_link, $method, $act;

    public $search = '';

    public $sortField = 'id';

    public $sortDirection = 'desc';

    protected $listeners = ['refreshLinks' => '$refresh'];

    public function mount(Deeplink $rowId)
    {
        (new Helper)->getAccountInfo();
        $this->act = session()->get('account')->id;
        $this->proj = $rowId->project;
    }

    public function updated($url, $short_link)
    {
        $this->validateOnly($url);
        $this->validateOnly($short_link);
    }


    public function rules()
    {
        return [
            'url' => 'required|url',
            'project' => 'nullable',
            'short_link' => [
                'required',
                Rule::unique('links', 'short_link')->ignore($this->deeplinkId)
            ],
        ];
    }

    private function resetInputFields()
    {
        $this->deeplinkId = '';
        $this->url = '';
        $this->project = '';
        $this->short_link = '';
        $this->method = '';
    }

    public function render()
    {
        $this->search = str_replace(env('APP_URL').'/go/', '', $this->search);

        return view('livewire.link', [
            'links' => Deeplink::where('account', $this->act)->searchIn(['url', 'short_link', 'project'],
                $this->search)->orderBy($this->sortField, $this->sortDirection)->with('getProject')->paginate(10),
            'projects' => Project::where('account', $this->act)->get(),
            'alert' => 'alert',
            'success' => 'success'
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->method = 'store';
        $this->short_link = $this->generateShortUrl();
    }

    public function store()
    {
        $data = $this->validate();

        $deeplink = Deeplink::create([
            'account' => $this->act,
            'project' => $data['project'] === "" ? null : $data['project'],
            'url' => $data['url'],
            'short_link' => $data['short_link'],
            'status' => 1,
        ]);

        (new Helper)->linkMessageFlash($deeplink);

    }

    public function edit(Deeplink $rowId)
    {
        $this->resetInputFields();
        $this->method = 'update';
        $this->updateMode = true;
        $this->proj = $rowId->project ?? null;
        $this->deeplinkId = $rowId->id ?? null;;
        $this->project = $rowId->project ?? null;;
        $this->url = $rowId->url ?? null;;
        $this->short_link = $rowId->short_link ?? null;;
    }

    public function update()
    {
        $data = $this->validate();

        $deeplink = Deeplink::where('id', $this->deeplinkId)->first();

        $deeplink->update([
            'project' => $data['project'] === "" ? null : $data['project'],
            'url' => $data['url'],
            'short_link' => $data['short_link']
        ]);

        (new Helper)->linkMessageFlash($deeplink);

    }

    public function destroy(Deeplink $deeplink)
    {
        $deeplink->delete();
        $this->resetInputFields();
        $this->render();
        $url = '"'.substr($deeplink->url, 0, 30).'..."';

        session()->flash('error', "O link {$url} foi deletado com sucesso!");
    }

    public function generateShortUrl()
    {
        $result = base_convert(rand(1000, 99999), 10, 36);
        $data = Deeplink::where('short_link', $result)->first();

        if ($data !== null) {
            $this->generateShortUrl();
        }

        return $result;
    }
}
