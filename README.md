# flux-file-storage-rest-api

File Storage Rest Api

## Permission issues

If you have permission issues in the file-storage directory, you need to give the www-data user write permissions with the follow command like

```shell
docker exec -u root:root %container_name% chown www-data:www-data -R /file-storage
```

## Environment variables

First look at [flux-file-storage-api](https://github.com/flux-eco/flux-file-storage-api#environment-variables)

| Variable | Description | Default value |
| -------- | ----------- | ------------- |
| FLUX_FILE_STORAGE_REST_API_SERVER_HTTPS_CERT | Path to HTTPS certificate file<br>Set this will enable listen on HTTPS<br>Should be on a volume | - |
| FLUX_FILE_STORAGE_REST_API_SERVER_HTTPS_KEY | Path to HTTPS key file<br>Should be on a volume | - |
| FLUX_FILE_STORAGE_REST_API_SERVER_LISTEN | Listen IP | 0.0.0.0 |
| FLUX_FILE_STORAGE_REST_API_SERVER_PORT | Listen port | 9501 |
| FLUX_FILE_STORAGE_REST_API_SERVER_MAX_UPLOAD_SIZE | Maximal file upload size | 104857600 |

Minimal variables required to set are **bold**

## Example

[examples](examples)
