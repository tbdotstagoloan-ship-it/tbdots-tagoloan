
            <!-- Delete Button triggers Modal -->
            <button type="button" class="btn btn-danger"
                data-bs-toggle="modal" data-bs-target="#confirmDeleteAccountModal">
                {{ __('Delete Account') }}
            </button>

            <!-- Modal -->
            <div class="modal fade" id="confirmDeleteAccountModal" tabindex="-1" aria-labelledby="confirmDeleteAccountModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('delete')

                            <div class="modal-header">
                                <h5 class="modal-title text-danger" id="confirmDeleteAccountModalLabel">
                                    {{ __('Are you sure you want to delete your account?') }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <p class="text-sm text-muted">
                                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                </p>

                                <div class="mb-3 mt-3">
                                    <label for="password" class="form-label sr-only">{{ __('Password') }}</label>
                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        class="form-control"
                                        placeholder="{{ __('Password') }}"
                                    >
                                    @if ($errors->userDeletion->get('password'))
                                        <div class="text-danger mt-1">
                                            {{ $errors->userDeletion->first('password') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    {{ __('Cancel') }}
                                </button>
                                <button type="submit" class="btn btn-danger ms-2">
                                    {{ __('Delete Account') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
