from flask import Flask, request, jsonify

app = Flask(__name__)

@app.route('/model', methods=['POST'])
def process_name():
    name = request.form.get('name')
    print(name)
    data = request.get_json()
    imageUrls = data.get('imageUrls', [])
    print(imageUrls)
    response = {'name': name}
    return jsonify(response)

if __name__ == '__main__':
    app.run()
