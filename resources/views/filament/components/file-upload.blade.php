<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isAvatar() || $isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div
        x-data="fileUploadFormComponent({
            acceptedFileTypes: {{ json_encode($getAcceptedFileTypes()) }},
            deleteUploadedFileUsing: async (fileKey) => {
                return await $wire.deleteUploadedFile('{{ $getStatePath() }}', fileKey)
            },
            getUploadedFileUrlUsing: async (fileKey) => {
                return await $wire.getUploadedFileUrl('{{ $getStatePath() }}', fileKey)
            },
            imageCropAspectRatio: {{ ($aspectRatio = $getImageCropAspectRatio()) ? "'{$aspectRatio}'" : 'null' }},
            imagePreviewHeight: {{ ($height = $getImagePreviewHeight()) ? "'{$height}'" : 'null' }},
            imageResizeTargetHeight: {{ ($height = $getImageResizeTargetHeight()) ? "'{$height}'" : 'null' }},
            imageResizeTargetWidth: {{ ($width = $getImageResizeTargetWidth()) ? "'{$width}'" : 'null' }},
            loadingIndicatorPosition: '{{ $getLoadingIndicatorPosition() }}',
            panelAspectRatio: {{ ($aspectRatio = $getPanelAspectRatio()) ? "'{$aspectRatio}'" : 'null' }},
            panelLayout: {{ ($layout = $getPanelLayout()) ? "'{$layout}'" : 'null' }},
            placeholder: {{ ($placeholder = $getPlaceholder()) ? "'{$placeholder}'" : 'null' }},
            maxSize: {{ ($size = $getMaxSize()) ? "'{$size} KB'" : 'null' }},
            minSize: {{ ($size = $getMinSize()) ? "'{$size} KB'" : 'null' }},
            removeUploadedFileUsing: async (fileKey) => {
                return await $wire.removeUploadedFile('{{ $getStatePath() }}', fileKey)
            },
            removeUploadedFileButtonPosition: '{{ $getRemoveUploadedFileButtonPosition() }}',
            state: $wire.{{ $applyStateBindingModifiers('entangle(\'' . $getStatePath() . '\')') }},
            uploadButtonPosition: '{{ $getUploadButtonPosition() }}',
            uploadProgressIndicatorPosition: '{{ $getUploadProgressIndicatorPosition() }}',
            uploadUsing: async (fileKey, file, success, error, progress) => {
                $wire.uploadToken({ name: file.name, size: file.size, type: file.type }).then(token => {
                    let request = new XMLHttpRequest()
                    request.open('post', 'https://upload-z2.qiniup.com/')

                    let formData = new FormData()
                    formData.append('file', file)
                    formData.append('token', token)

                    request.upload.addEventListener('progress', e => {
                        e.detail = {}
                        e.detail.progress = Math.round((e.loaded * 100) / e.total)

                        progress(e)
                    })

                    request.addEventListener('load', () => {
                        console.log(JSON.parse(request.responseText))
                        if(request.status < 300){
                            $wire.finishUploadByQiniu(`{{ $getStatePath() }}.${fileKey}`, JSON.parse(request.responseText).path)
                            success(fileKey)
                        } else {
                            error()
                        }
                    })

                    request.send(formData)
                }).catch(err => {
                    error()
                })
            },
        })"
        wire:ignore
        {{ $attributes->merge($getExtraAttributes())->class([
            'w-32 mx-auto' => $isAvatar(),
        ]) }}
        {{ $getExtraAlpineAttributeBag() }}
    >
        <input
            x-ref="input"
            {{ $isDisabled() ? 'disabled' : '' }}
            {{ $isMultiple() ? 'multiple' : '' }}
            {!! ($id = $getId()) ? "id=\"{$id}\"" : null !!}
            type="file"
            {{ $getExtraInputAttributeBag() }}
        />
    </div>
</x-forms::field-wrapper>
