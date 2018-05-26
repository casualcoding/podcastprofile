<div class="uk-alert uk-alert-danger uk-margin-top">
    <p>Do you really want to delete your account? The data we have stored about you will be removed immediately.</p>
    <form class=" uk-margin-top" action="{{ URL::route('api::postDeleteAccount') }}" method="post">
        {{ csrf_field() }}
        <button class="uk-button uk-button-danger" onclick="return confirm('Are you sure?')"><i class="uk-icon-warning"></i> Delete Account</button>
    </form>
</div>