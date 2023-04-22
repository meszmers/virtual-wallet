<div class="header">
    @if(!empty(session()->get('u-token')))
        I am logged in
    @else
        I am logged off
    @endif
</div>

<style>
    .header {
        background-color: gray;
        height: 200px;
    }
</style>
