import jwt
import datetime

# Define the secret key used to sign the token
SECRET_KEY = "thisisasecretkeywhichshouldnotbeexposedtoanyoneandshouldbekeptconfidential"


class TokenExpiredError(Exception):
    pass


class InvalidTokenError(Exception):
    pass


def generate_jwt(payload):
    """
    Generate a JWT token with an expiration time extended by one month.

    Args:
        payload (dict): The payload (claims) to include in the token.

    Returns:
        str: The generated JWT token.
    """
    # Calculate the expiration time (one month from now)
    expiration_time = datetime.datetime.utcnow() + datetime.timedelta(days=30)

    # Add the expiration time to the payload
    payload['exp'] = expiration_time

    # Generate the token
    token = jwt.encode(payload, SECRET_KEY, algorithm="HS256")

    return token


def verify_jwt(token):
    """
    Verify and decode a JWT token.

    Args:
        token (str): The JWT token to verify and decode.

    Returns:
        dict: The decoded payload if the token is valid.

    Raises:
        TokenExpiredError: If the token has expired.
        InvalidTokenError: If the token is invalid.
    """
    try:
        # Decode and verify the token
        decoded_token = jwt.decode(token, SECRET_KEY, algorithms=["HS256"])

        # Check token expiration
        if 'exp' in decoded_token:
            token_exp = datetime.datetime.utcfromtimestamp(decoded_token['exp'])
            current_time = datetime.datetime.utcnow()
            if token_exp < current_time:
                raise TokenExpiredError("Token has expired")
            else:
                return decoded_token
        else:
            raise InvalidTokenError("Token expiration time not found")

    except jwt.ExpiredSignatureError:
        raise TokenExpiredError("Token has expired")
    except jwt.InvalidTokenError:
        raise InvalidTokenError("Invalid token")
